<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php
    $css = ["/css/cliente/tarefa.css", "/css/geral/navbar.css"];
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
    <main class="f-column">
        <div class="tarefas-title">
            Tarefas para você
        </div>
        <div class="tarefas-div" data-tarefas='<?= json_encode($tarefas) ?>'>
        </div>
    </main>

</body>
<script src="./app/components/js/footer.js"></script>
<script type="module" src="./public/js/cliente/tarefas.js"></script>
</html>