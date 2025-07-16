<!DOCTYPE html>
<html lang="pt-br">

<?php
  $css = ['/css/style.css', '/css/cliente/search.css', '/css/geral/navbar.css'];
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
    <div class="search-container">
      <div class="search-content">
        <input type="text" placeholder="Pesquisar loja..." class="search-input">
        <button class="search-button">
          <img src="./public/images/icons/icon_search_pesquisar.svg" alt="search" class="search-icon">
        </button>
      </div>
    </div>

    <ul class="search-results">
      
    </ul>
  </div>
</body>
<script type="module" src="./public/js/cliente/search.js"></script>
</html>