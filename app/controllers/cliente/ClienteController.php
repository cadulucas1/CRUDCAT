<?php

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
}
