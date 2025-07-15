<?php

class GeralController extends RenderView {

    public function index() {
        $this->loadView('geral/home' ,[]);
    }

    public function navbar() {
        $this->loadView('geral/navbar' ,[]);
    }

    public function perfil_loja() {
        $this->loadView('geral/perfil_loja' ,[]);
    }

}