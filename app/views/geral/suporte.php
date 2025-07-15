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
  <main class="f-column" id="main-content">
    <form class="form-suporte">
      
      <div class="div-input-assunto">
        <input type="text" placeholder="Assunto" class="input-assunto" name="assunto">
      </div>

      <div class="div-input-mensagem">
        <textarea placeholder="Mensagem..." class="input-mensagem" name="assunto"></textarea>
      </div>

      <button type="submit"class="btn-enviar-mensagem" name="enviar">
        ENVIAR MENSAGEM
        <img src="./public/images/icons/icon_enviar_mensagem.svg" alt="aviaozinho" class="icon-mensagem">
      </button>

    </form>
  </main>
    
</body>
</html>