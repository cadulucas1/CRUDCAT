<?php

// session_start();
// $current_url = $_SERVER['REQUEST_URI']; URL atual do site

   /* Lista de stylesheets para carregar na página
   * @var string $titulo
   */
  if(!isset($titulo)) {
    $titulo = "MiniComunica";
  }

  /**
   * Lista de stylesheets para carregar na página
   * @var string[] $css
   */
  if(!isset($css)) {
    $css = [];
  }

  /**
   * Lista de scripts para carregar na página
   * @var string[] $js
   */
  if(!isset($js)) {
    $js = [];
  }

  $PATH_PUBLIC = "./public";
  $PATH_COMPONENTS = "./app/components";
  $PATH_CONTROLLER = './app/controllers';

  $head = "
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='icon' type='image/x-icon' href='$PATH_PUBLIC/images/favicon.svg'>
    <title>$titulo</title>
    <link rel='stylesheet' href='$PATH_PUBLIC/css/style.css'>
";

//concatena os CSSs e Scripts
$str_css = implode('', array_map(fn($item): string => "<link rel='stylesheet' href='$PATH_PUBLIC$item'>", $css));
$str_js = implode('', array_map(fn($item): string => "<script src='$PATH_PUBLIC$item'></script>", $js));

//Valor final injetado na tela
echo $head . $str_css . $str_js . "</head>";