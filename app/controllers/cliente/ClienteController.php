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

    public function getLojasSeguidas() {
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
}
