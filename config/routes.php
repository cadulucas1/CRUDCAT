<?php

$routes = [

    // Rotas Gerais
    '/' => 'geral/GeralController@index',
    // '/navbar' => 'geral/GeralController@navbar',
    '/Loja' => 'geral/GeralController@perfil_loja',
    '/suporteAdm' => 'geral/SuporteAdmController@suporteAdm',
    '/enviarSuporte' => 'cliente/SuporteController@enviarSuporte',


    // Rotas Cliente
    '/search' => 'cliente/SearchController@search',
    '/suporte' => 'cliente/SuporteController@suporte',
    '/login' => 'cliente/ClienteController@login',
    '/cadastro' => 'cliente/ClienteController@cadastro',
    '/getLojasSeguidas' => 'cliente/ClienteController@getLojasSeguidas',
    '/perfil' => 'cliente/ClienteController@perfil',
    '/perfil-salvar' => 'cliente/ClienteController@salvarPerfil',
    '/toggleSeguirLoja' => 'cliente/ClienteController@toggleSeguirLoja',
    '/cupons' => 'cliente/ClienteController@cupons',
    '/comprar-cupom' => 'cliente/ClienteController@comprarCupom',
    '/search-lojas' => 'cliente/ClienteController@searchLojas',
    '/tarefas' => 'cliente/ClienteController@tarefas',
    '/realizar-tarefa' => 'cliente/ClienteController@realizarTarefa',
]

?>