<!DOCTYPE html>
<html lang="pt-br">

<?php
$css = ['/css/style.css', '/css/geral/navbar.css', '/css/adm/suporteAdm.css'];
require_once('./utils/head.php')
?>

<body>
  <?php
  include './app/components/php/navbar.php';
  ?>
  <?php
  // $topBarClass = 'estendida'; 
  include './app/components/php/topbar.php';
  ?>
  <div class="page-container">
    <div class="dados-chamado">
      <div class="div-dados-cliente">
        <div class="chamado-codigo">
          <h3>Código do Chamado: <span class="codigo"># 12345</span></h3>
        </div>
        <div class="chamado-cliente">
          <h3>Cliente: <span class="nome-cliente">Cliente01</span></h3>
        </div>
        <div class="chamado-data">
          <h3>Data: <span class="data">01/01/2023</span></h3>
        </div>
      </div>
      <div class="div-assunto-mensagem">
        <div class="assunto">
          <h3>Assunto: <span class="assunto-texto">Pedir para meu condomínio.</span></h3>
        </div>
        <div class="mensagem">
          <h3>Mensagem: <span class="mensagem-texto">Olá, gostaria de solicitar um mini mercado da BuyAtHome no meu condomínio.</span></h3>
        </div>
      </div>
    </div>
    <div class="titulo-resposta">
      <h3 id="responder">Responder:</h3>
    </div>
    <form class="form-suporte-adm" action="" method="post">
      <textarea class="textarea-resposta" placeholder="Digite sua resposta aqui..." name="resposta"></textarea>

      <button type="submit" class="btn-enviar-mensagem" name="enviar">
        ENVIAR MENSAGEM
        <img src="./public/images/icons/icon_enviar_mensagem.svg" alt="aviaozinho" class="icon-mensagem">
      </button>
    </form>
  </div>
</body>
</html>