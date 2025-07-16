<?php

require_once __DIR__ . '/../../models/geral/GeralModel.php';

class GeralController extends RenderView {

    public function index() {
        $this->loadView('geral/home' ,[]);
    }

    public function navbar() {
        $this->loadView('geral/navbar' ,[]);
    }

    public function perfil_loja() {
        $idUser = isset($_GET['id_user']) ? intval($_GET['id_user']) : 0;
        $idLoja = isset($_GET['id_loja']) ? intval($_GET['id_loja']) : 0;
    
        if ($idLoja <= 0 || $idUser <= 0) {
            $this->loadView('geral/error', []);
            exit;
        }
    
        $model = new GeralModel();
    
        $loja = $model->getLojaProdutoByIdComSeguimento($idUser, $idLoja);
    
        if (empty($loja)) {
            $this->loadView('geral/error', []);
            exit;
        }
    
        // echo $loja['nome_loja']; 
        // foreach ($loja['produtos'] as $produto) {
        //     echo $produto['nome_produto'] . ' - ' . $produto['preco_venda_loja'];
        // }
    
        $this->loadView('geral/perfil_loja', [
            'loja' => $loja,
            'seguindo' => $loja['seguindo']
        ]);
    }
    
}