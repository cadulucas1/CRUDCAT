<!DOCTYPE html>
<html lang="pt-br">

<?php
$css = ['/css/cliente/login.css', '/css/geral/navbar.css'];
require_once('./utils/head.php')
?>

<body>
    <?php
        include './app/components/php/navbar.php';
        include './app/components/php/topbar.php'; 
    ?>
    <div class="login-card">
        <form id="formLogin" novalidate>
            <h2 class="login-title">Entrar</h2>

            <div class="input-group">
                <img src="./public/images/icons/icon_email.svg" alt="Ícone de email" class="input-icon">
                <input type="email" id="loginEmail" placeholder="E-mail" required />
                <span class="error-message" id="erro-loginEmail"></span>
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_senha.svg" alt="Ícone de senha" class="input-icon">
                <input type="password" id="loginSenha" placeholder="Senha" required />
                <span class="error-message" id="erro-loginSenha"></span>
            </div>
            <button type="submit" class="btn-base login-btn">
                <img src="./public/images/icons/icon_login.svg" alt="Ícone login" class="btn-icon">
                Logar
            </button>
            <div class="login-message">
                <p onclick="pag('cadastro')">
                    Não tem uma conta?
                    <a>Cadastre-se</a>
                </p>
            </div>
        </form>
    </div>
    <script src="./public/js/cliente/login.js"></script>
</body>

</html>