<!DOCTYPE html>
<html lang="pt-br">

<?php
$css = ['/css/cliente/editarPerfil.css', '/css/geral/navbar.css'];
require_once('./utils/head.php');
?>

<body>
    <?php
    include './app/components/php/navbar.php';
    include './app/components/php/topbar.php';
    ?>

    <main>
        <form class="form-container" method="POST" action="/editarPerfil/salvar" enctype="multipart/form-data">
            <div class="avatar">
                <img src="./public/images/fotos/foto_default.svg" alt="Foto de perfil" />
            </div>

            <div class="input-group">
                <input type="text" name="nome" placeholder="Seu nome completo" value="<?= $usuario['nome'] ?? '' ?>" readonly />
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="seuemail@exemplo.com" value="<?= $usuario['email'] ?? '' ?>" readonly />
            </div>
            <div class="input-group">
                <input type="tel" name="telefone" placeholder="(67) 99999-9999" value="<?= $usuario['telefone'] ?? '' ?>" readonly />
            </div>
            <div class="input-group">
                <input type="password" name="senha" placeholder="Senha" readonly />
            </div>
            <div class="input-group" id="campo-confirmar-senha" style="display: none;">
                <input type="password" name="confirmar_senha" placeholder="Confirmar nova senha" readonly />
            </div>



            <button type="button" class="btn-base" id="btnEditar">Editar</button>
            <button type="submit" class="btn-base" id="btnConfirmar" disabled>Confirmar</button>
        </form>
    </main>

    <script src="./components/js/toast.js"></script>
    <script src="./public/js/cliente/editarPerfil.js"></script>

</body>

</html>