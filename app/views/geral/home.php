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
        // include './app/components/php/topbar.php'; 
    ?>
    <main class="f-column" id="main-content">
        <div class="store-div">
            <div></div>
        </div>
    </main>
    
</body>
<script type="module" src="./public/js/geral/home.js"></script>
</html>