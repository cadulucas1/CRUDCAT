<!DOCTYPE html>
<html lang="pt-br">
<?php
    $css = ['/css/geral/home.css'];
    require_once('./utils/head.php')
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $topBarClass = 'estendida'; 
        include './app/components/php/topbar.php'; 
    ?>
    <main class="f-column" id="main-content">
    </main>
</body>
<script src="./public/js/geral/home.js"></script>
</html>