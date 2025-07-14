<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $css = ['/css/style.css', '/css/header.css', '/css/search.css'];
  require_once('./utils/head.php')
  ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <header class="header-container">
    <div class="header-content">
      <img src="public/images/logo.png" alt="MiniComunica" class="header-logo">
    </div>
  </header>

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
      <li class="card-result">
        <div class="image-loja"></div>
        <div class="dados-loja">
          <h3 class="loja-nome">Comper Itanhangá</h3>
          <p class="loja-endereco">
            <img src="./public/images/icons/icon_localizacao.svg" alt="ícone localização" class="dados-icone" id="icon-localizacao">
            Rua Joaquim Murtinho, 975
          </p>
          <p class="loja-status">
            <img src="./public/images/icons/icon_status.svg" alt="ícone status" class="dados-icone" id="icon-status">
            Status: <span class="status-aberto">Aberto</span>
          </p>
          <p class="loja-horario">
            <img src="./public/images/icons/icon_relogio.svg" alt="ícone horário" class="dados-icone" id="icon-horario">
            Fechado das 23h às 7h
          </p>
        </div>
      </li>

      <li class="card-result">
        <div class="image-loja"></div>
        <div class="dados-loja">
          <h3 class="loja-nome">Condomínio Jardim das Flores</h3>
          </h3>
          <p class="loja-endereco">
            <img src="./public/images/icons/icon_localizacao.svg" alt="ícone localização" class="dados-icone" id="icon-localizacao">
            Rua Campo Limpo, 333
          </p>
          <p class="loja-status">
            <img src="./public/images/icons/icon_status.svg" alt="ícone status" class="dados-icone" id="icon-status">
            Status: <span class="status-fechado">Fechado</span>
          </p>
          <p class="loja-horario">
            <img src="./public/images/icons/icon_relogio.svg" alt="ícone horário" class="dados-icone" id="icon-horario">
            Fechado das 23h às 7h
          </p>
        </div>
      </li>
    </ul>
  </div>
</body>

</html>