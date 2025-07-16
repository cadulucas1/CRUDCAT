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
    <main class="f-column" id="main-content">
        <h2 class="title-store">
            Lojas Seguidas
        </h2>
        <ul class="store-div">
        </ul>
    </main>
    
</body>
<script type="module" src="./public/js/geral/home.js"></script>
<script type="module" src="./app/components/js/giftCard.js"></script>
</html>