<?php
require_once(__DIR__ . '/../../config/database.php'); // Ajuste o caminho conforme necessário

class User {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }

    public function login($emailRaw, $senhaRaw) {
        session_start();

        // Sanitização
        $email = filter_var($emailRaw, FILTER_SANITIZE_EMAIL);
        $senha = $senhaRaw;

        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Autenticado com sucesso
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'nome' => $usuario['nome'],
                    'email' => $usuario['email']
                ];
                return true;
            } else {
                $_SESSION['erro_login'] = "Credenciais inválidas!";
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Erro ao autenticar usuário: " . $e->getMessage());
        }
    }
}

