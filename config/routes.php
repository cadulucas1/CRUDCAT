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
<<<<<<< HEAD
    '/perfil-salvar' => 'cliente/ClienteController@salvarPerfil',

=======
    '/toggleSeguirLoja' => 'cliente/ClienteController@toggleSeguirLoja',
>>>>>>> 2145986e15976884e899625f17f0de21575b3280

]

?>