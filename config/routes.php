<?php

$routes = [
    '/' => 'geral/GeralController@index',
    '/search' => 'geral/searchController@search',
    '/navbar' => 'geral/GeralController@navbar',
    '/Loja' => 'geral/GeralController@perfil_loja',
    '/suporte' => 'geral/suporteController@suporte',
    '/suporteAdm' => 'geral/suporteAdmController@suporteAdm',
    '/login' => 'cliente/ClienteController@login',
    '/cadastro' => 'cliente/ClienteController@cadastro',
    '/getLojasSeguidas' => 'cliente/ClienteController@getLojasSeguidas',
    '/perfil' => 'cliente/ClienteController@perfil',
]

?>