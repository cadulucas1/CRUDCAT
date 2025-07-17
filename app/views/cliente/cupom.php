<!DOCTYPE html>
<html lang="pt-br">
<?php
    $css = ['/css/cliente/cupons.css', '/css/geral/navbar.css'];
    require_once('./utils/head.php')
?>
</head>
<body>
    <?php
        include './app/components/php/navbar.php';
    ?>
    <?php 
        include './app/components/php/topbar.php'; 
    ?>
    <main class="f-column" id="main-content">
        <div class="pontos-user">
            <h2>Seus pontos: 
                <h3 id="pontos-user"><?= $pontos ?></h3>
            </h2>
        </div>
        <div class="render-cupons" id="render-cupons" data-cupons[]='<?= htmlspecialchars(json_encode($cupons), ENT_QUOTES) ?>'>
        </div>
        <div class="btn-box">
            <button class="btn-base" onclick="pag('tarefas')">Sem pontos? Resolva tarefas!</button>
        </div>
    </main>
    <script src="./app/components/js/footer.js" class="footer"></script>
</body>
<script src="./public/js/cliente/renderCupons.js"></script>
</html>