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
        <form id="formCadastro" novalidate> 
            <h2 class="cadastro-title">Cadastre-se</h2>

            <div class="input-group">
                <img src="./public/images/icons/icon_user2.svg" alt="Ícone de nome" class="input-icon">
                <input type="text" id="nome" name="nome" placeholder="Nome Completo" required />
                <span class="error-message" id="erro-nome"></span>
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_email.svg" alt="Ícone de email" class="input-icon">
                <input type="email" id="email" name="email" placeholder="E-mail" required />
                <span class="error-message" id="erro-email"></span>
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_telefone.svg" alt="Ícone de telefone" class="input-icon">
                <input type="tel" id="telefone" name="telefone" placeholder="Telefone" required />
                <span class="error-message" id="erro-telefone"></span>
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_senha.svg" alt="Ícone de senha" class="input-icon">
                <input type="password" id="senha" name="senha" placeholder="Senha" required />
                <span class="error-message" id="erro-senha"></span>
            </div>

            <div class="input-group">
                <img src="./public/images/icons/icon_senha.svg" alt="Ícone de senha" class="input-icon">
                <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme a Senha" required />
                <span class="error-message" id="erro-confirmarSenha"></span>
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
    <script src = "./components/js/toast.js"></script>
    <script src="./public/js/cliente/cadastro.js"></script>
</body>

</html>