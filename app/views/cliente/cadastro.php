<!DOCTYPE html>
<html lang="pt-br">
<?php
$css = ['/css/cliente/cadastro.css', '/css/geral/navbar.css'];
require_once('./utils/head.php')
?>

<body>
    <?php
        include './app/components/php/navbar.php';
        include './app/components/php/topbar.php'; 
    ?>
    <div class="cadastro-card">
        <form>
            <h2 class="cadas    tro-title">Cadastre-se</h2>
            <div class="input-group">
                <img src="./public/images/icons/icon_user.svg" alt="Ícone de nome" class="input-icon">
                <input type="text" placeholder="Nome Completo" required />
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_email.svg" alt="Ícone de email" class="input-icon">
                <input type="email" placeholder="E-mail" required />
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_telefone.svg" alt="Ícone de telefone" class="input-icon">
                <input type="number" placeholder="Telefone" required />
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_senha.svg" alt="Ícone de senha" class="input-icon">
                <input type="password" placeholder="Senha" required />
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_senha.svg" alt="Ícone de senha" class="input-icon">
                <input type="password" placeholder="Confirme a Senha" required />
            </div>

            <button type="submit" class="btn-base cadastro-btn">
                <img src="./public/images/icons/icon_login.svg" alt="Ícone login" class="btn-icon">
                Cadastrar
            </button>
            <div class="cadastro-message">
                <p onclick="pag('login')">
                    Já tem uma conta?
                    <a>Logar</a>
                </p>
            </div>
        </form>
    </div>
</body>

</html>