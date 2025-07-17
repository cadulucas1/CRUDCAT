<!DOCTYPE html>
<html lang="pt-br">
<?php
    $css = ['/css/cliente/suporte.css', '/css/geral/navbar.css'];
    require_once('./utils/head.php')
?>
</head>

<body>
  <?php
      include './app/components/php/navbar.php';
  ?>
  <?php 
      // $topBarClass = 'estendida'; 
      include './app/components/php/topbar.php'; 
  ?>
  <div class="page-container">
    <form class="form-suporte" method="post" action="">
      <div class="div-titulo-suporte">
        <h1 class="titulo-suporte">Suporte</h1>
        <p class="texto-suporte">Preencha o formulário abaixo para entrar em contato com a equipe BuyAtHome
        </p>
      </div>
      <div class="div-input-assunto">
        <input type="text" placeholder="Assunto" class="input-assunto" name="assunto">
      </div>

      <div class="div-input-mensagem">
        <textarea placeholder="Mensagem..." class="input-mensagem" name="mensagem"></textarea>
      </div>

      <button type="submit"class="btn-enviar-mensagem" name="enviar">
        ENVIAR MENSAGEM
        <img src="./public/images/icons/icon_enviar_mensagem.svg" alt="aviaozinho" class="icon-mensagem">
      </button>

    </form>
  </div>
  <script src="./app/components/js/footer.js"></script>
</body>
<script type="module" src="./public/js/cliente/suporte.js"></script>
</html>