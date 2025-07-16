<?php

$routes = [

    // Rotas Gerais
    '/' => 'geral/GeralController@index',
    '/navbar' => 'geral/GeralController@navbar',
    '/Loja' => 'geral/GeralController@perfil_loja',
    '/suporteAdm' => 'geral/SuporteAdmController@suporteAdm',
    '/enviarSuporte' => 'geral/SuporteController@enviarSuporte',


    // Rotas Cliente
    '/search' => 'cliente/SearchController@search',
    '/suporte' => 'cliente/SuporteController@suporte',
    '/login' => 'cliente/ClienteController@login',
    '/cadastro' => 'cliente/ClienteController@cadastro',
    '/getLojasSeguidas' => 'cliente/ClienteController@getLojasSeguidas',
    '/perfil' => 'cliente/ClienteController@perfil',
    '/toggleSeguirLoja' => 'cliente/ClienteController@toggleSeguirLoja',

]

?>