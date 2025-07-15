<?php

$routes = [
    '/' => 'geral/GeralController@index',
    '/navbar' => 'geral/GeralController@navbar',
    '/PerfilLoja' => 'geral/GeralController@perfil_loja',
    '/login' => 'cliente/ClienteController@login',
    '/cadastro' => 'cliente/ClienteController@cadastro',
]


?>