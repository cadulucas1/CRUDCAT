<?php

require_once __DIR__ . '/../../models/cliente/ClienteModel.php';
require_once __DIR__ . '/../../models/cliente/UsuarioModel.php';

class ClienteController extends RenderView
{
    public function login()
    {
        $this->loadView('cliente/login', []);
    }

    public function cadastro()
    {
        $this->loadView('cliente/cadastro', []);
    }

    public function perfil()
    {
        // ⛔️ Ainda não temos login implementado, então para teste usa id fixo
        $id_usuario = 1; // Depois use $_SESSION['usuario_id']

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->getUsuarioById($id_usuario);

        $this->loadView('cliente/perfil', ['usuario' => $usuario]);
    }

    public function getLojasSeguidas()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');

        $idUsuario = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($idUsuario <= 0) {
            echo json_encode(['erro' => 'Usuário não logado']);
            exit;
        }

        $model = new ClienteModel();
        $resposta = $model->getLojasById($idUsuario);

        if (empty($resposta)) {
            echo json_encode(['alerta' => 'Você não segue nenhuma loja']);
            exit;
        }

        echo json_encode($resposta);
    }

    public function salvarPerfil()
    {
        // session_start();

        // if (!isset($_SESSION['usuario_id'])) {
        //     header('Location: /login');
        //     exit;
        // }

        $id_usuario = $_SESSION['usuario_id'] ?? 1;

        $nome     = trim($_POST['nome'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $senha    = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        if (empty($nome) || empty($email) || empty($telefone)) {
            $_SESSION['mensagem_erro'] = 'Nome, e-mail e telefone são obrigatórios.';
            header('Location: /CRUDCAT/perfil');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensagem_erro'] = 'E-mail inválido.';
            header('Location: /CRUDCAT/perfil');
            exit;
        }

        if (!empty($senha) || !empty($confirmarSenha)) {
            if ($senha !== $confirmarSenha) {
                $_SESSION['mensagem_erro'] = 'As senhas não coincidem.';
                header('Location: /CRUDCAT/perfil');
                exit;
            }
            if (strlen($senha) < 6) {
                $_SESSION['mensagem_erro'] = 'A senha deve ter pelo menos 6 caracteres.';
                header('Location: /CRUDCAT/perfil');
                exit;
            }
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        } else {
            $senhaHash = null;
        }

        $usuarioModel = new UsuarioModel();

        if ($senhaHash) {
            $usuarioModel->atualizarPerfilComSenha($id_usuario, $nome, $email, $telefone, $senhaHash);
        } else {
            $usuarioModel->atualizarPerfilSemSenha($id_usuario, $nome, $email, $telefone);
        }

        $_SESSION['mensagem_sucesso'] = 'Perfil atualizado com sucesso!';
        header('Location: /CRUDCAT/perfil');
        exit;
    }
}
