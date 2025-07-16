<?php

require_once __DIR__ . "/../../models/cliente/SuporteModel.php";

class SuporteController extends RenderView {

    public function suporte() {
        $this->loadView('cliente/suporte' ,[]);
    }

    public function enviarSuporte()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['erro', 'mensagem'=> 'Método não permitido']);
            exit;
        }
        
        $assunto = trim(strip_tags($_POST['assunto'] ?? ''));
        $mensagem = trim(strip_tags($_POST['mensagem'] ?? ''));
       

        if (empty($assunto) || empty($mensagem)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['erro' => 'Assunto e mensagem são campos obrigatórios.']);
            exit;
        }

        if (strlen($assunto) < 5 || strlen($assunto) > 100) { // Exemplo: mínimo 5, máximo 100 caracteres
            http_response_code(400);
            echo json_encode(['status' => 'erro', 'mensagem' => 'O assunto deve ter entre 5 e 100 caracteres.']);
            exit;
        }

        if (strlen($mensagem) < 10 || strlen($mensagem) > 1000) { // Exemplo: mínimo 10, máximo 1000 caracteres
            http_response_code(400);
            echo json_encode(['status' => 'erro', 'mensagem' => 'A mensagem deve ter entre 10 e 1000 caracteres.']);
            exit;
        }

        $idUsuario = 1;

        $model = new SuporteModel();
        $sucesso = $model->enviarMensagemSuporte($assunto, $mensagem, $idUsuario);


        if ($sucesso) {
            echo json_encode(['sucesso' => 'Sua mensagem de suporte foi enviada com sucesso!']);
        } else {
            echo json_encode(['erro' => 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.']);
        }
        exit;
    }

}