<?php

require_once __DIR__ . '/../../models/cliente/ClienteModel.php';

class ClienteController extends RenderView
{

    public function login()
    {
        $this->loadView('cliente/login', []);
    }
    // função de cadastrar usuario
    public function cadastro()
    {   $erro='';
        $sucesso='';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $confirmar = $_POST['confirmarSenha'] ?? '';

            if (empty($nome) || empty($email) || empty($telefone) || empty($senha) || empty($confirmar)) {
                $erro = "Preencha todos os campos.";
            } elseif ($senha !== $confirmar) {
                $erro = "As senhas não coincidem.";
            } else {
                $model = new ClienteModel();
                $ok = $model->cadastrar($nome, $email, $telefone, $senha);

                if ($ok) {
                    $sucesso = "Cadastro realizado com sucesso!";
                    // redirecionar para login
                    header('Location: /CRUDCAT/login');
                    exit;
                } else {
                    $erro = "Erro ao salvar no banco de dados.";
                }
            }
        }

        $this->loadView('cliente/cadastro', [
            'erro' => $erro,
            'sucesso' => $sucesso
        ]);

    }

    public function perfil()
    {
        $this->loadView('cliente/perfil', []);
    }

    public function getLojasSeguidas()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');

        $idUsuario = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $model = new ClienteModel;

        $resposta = $model->getLojasById($idUsuario);

        if ($idUsuario <= 0) {
            echo json_encode(['erro' => 'Usuário não logado']);
            exit;
        }

        if (empty($resposta)) {
            echo json_encode(['alerta' => 'Você não segue nenhuma loja']);
            exit;
        }

        echo json_encode($resposta);
    }

    public function toggleSeguirLoja() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido']);
            exit;
        }
    
        header('Content-Type: application/json; charset=utf-8');
    
        $payload = json_decode(file_get_contents('php://input'), true);
    
        $idUser = isset($payload['id_user']) ? intval($payload['id_user']) : 0;
        $idLoja = isset($payload['id_loja']) ? intval($payload['id_loja']) : 0;
        $seguir  = isset($payload['seguir']) ? (bool)$payload['seguir'] : null;
    
        if ($idUser <= 0 || $idLoja <= 0 || !is_bool($seguir)) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Parâmetros inválidos'
            ]);
            exit;
        }
    
        $model = new ClienteModel();
    
        $ok = $model->toggleSeguirLoja($idUser, $idLoja, $seguir);
    
        if ($ok) {
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => $seguir ? 'Agora você segue esta loja' : 'Você parou de seguir esta loja'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar status de seguimento'
            ]);
        }
    }
    
}
