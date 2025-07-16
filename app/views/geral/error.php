<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php
    $css = ["/css/geral/error.css", "/css/geral/navbar.css"];
    require_once('./utils/head.php');
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
    <main class="error_main">
        <div class="error_container_body">
            <img src="./public/images/fotos/error_foto.svg">
        </div>

        <div class="error_text">
            <h1>Ops...</h1>
            <h2>Parece que essa página não existe ;(</h2>
        </div>

        <button onclick="pag('')" class="error_btn">
            <img src="./public/images/icons/icon_home.svg">
            VOLTAR PARA A TELA INICIAL
        </button>
    </main>

</body>
</html>