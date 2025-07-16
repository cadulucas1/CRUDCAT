<?php

$routes = [
    '/' => 'geral/GeralController@index',
    '/search' => 'geral/SearchController@search',
    '/navbar' => 'geral/GeralController@navbar',
    '/Loja' => 'geral/GeralController@perfil_loja',
    '/suporte' => 'geral/SuporteController@suporte',
    '/suporteAdm' => 'geral/SuporteAdmController@suporteAdm',
    '/login' => 'cliente/ClienteController@login',
    '/cadastro' => 'cliente/ClienteController@cadastro',
    '/getLojasSeguidas' => 'cliente/ClienteController@getLojasSeguidas',
    '/enviarSuporte' => 'geral/SuporteController@enviarSuporte'
    '/perfil' => 'cliente/ClienteController@perfil',
]

?>