<!DOCTYPE html>
<html lang="pt-br">
<?php
$css = ['/css/geral/home.css', '/css/geral/navbar.css'];
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

    <main class="home-container-geral">
        <a href="https://www.buyathomebrasil.com.br/" target="blank">
            <div class="home-banner-container">
                <picture>
                    <source srcset="./public/images/fotos/banner_mobile.png" media="(max-width: 425px)">
                    <img src="./public/images/fotos/banner_desktop.png">
                </picture>
            </div>
        </a>

        <div id="main-content" class="main-content">
            <h2 class="title-store">
                Lojas Seguidas
            </h2>
            <ul class="store-div">
            </ul>
        </div>

        <div class="card-div-container" onclick="pag('tarefas')">
            <h2 class="title-store">
                Tarefa Diária
            </h2>
            <ul class="cardgift-div"></ul>
        </div> 
    </main>
</body>
<script type="module" src="./public/js/geral/home.js"></script>
<script src="./app/components/js/footer.js"></script>
<script type="module" src="./app/components/js/giftCard.js"></script>
</html>