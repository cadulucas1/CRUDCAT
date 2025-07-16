<!DOCTYPE html>
<html lang="pt-br">

<?php
$css = ['/css/cliente/perfil.css', '/css/geral/navbar.css'];
require_once('./utils/head.php');
?>

<body>
    <?php
    include './app/components/php/navbar.php';
    include './app/components/php/topbar.php';
    ?>

    <main>
        <h2>Tarefa do Dia</h2>
    </main>

    <script src="./components/js/toast.js"></script>
    <script src="./public/js/cliente/perfil.js"></script>

</body>

</html>