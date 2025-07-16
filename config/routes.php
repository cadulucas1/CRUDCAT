<?php

$routes = [
    '/' => 'geral/GeralController@index',
    '/search' => 'geral/searchController@search',
    '/navbar' => 'geral/GeralController@navbar',
    '/PerfilLoja' => 'geral/GeralController@perfil_loja',
    '/suporte' => 'geral/suporteController@suporte',
    '/suporteAdm' => 'geral/suporteAdmController@suporteAdm',
    '/login' => 'cliente/ClienteController@login',
    '/cadastro' => 'cliente/ClienteController@cadastro',
]

?>