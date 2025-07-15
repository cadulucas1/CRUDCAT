<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<?php
$css = ['/css/cliente/login.css'];
require_once('./utils/head.php')
?>

<body>
    <div class="login-card">
        <form>
            <h2 class="login-title">Entrar</h2>

            <div class="input-group">
                <img src="./public/images/icons/icon_email.svg" alt="Ícone de email" class="input-icon">
                <input type="email" placeholder="E-mail" required />
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_senha.svg" alt="Ícone de senha" class="input-icon">
                <input type="password" placeholder="Senha" required />
            </div>

            <button type="submit" class="btn-base login-btn">
                <img src="./public/images/icons/icon_login.svg" alt="Ícone login" class="btn-icon">
                Logar
            </button>
        </form>
    </div>
</body>

</html>