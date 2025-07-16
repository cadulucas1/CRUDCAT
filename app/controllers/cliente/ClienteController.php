<?php

require_once __DIR__ . '/../../models/cliente/ClienteModel.php';

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
