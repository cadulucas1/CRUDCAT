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
        <form class="form-container" method="POST" action="perfil-salvar" enctype="multipart/form-data">
            <div class="avatar">
                <img src="./public/images/fotos/foto_default.svg" alt="Foto de perfil" />
            </div>

            <div class="input-group">
                <input type="text" name="nome" placeholder="Seu nome completo" value="<?= $usuario['nome_usuario'] ?? '' ?>" readonly />
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="seuemail@exemplo.com" value="<?= $usuario['email_usuario'] ?? '' ?>" readonly />
            </div>
            <div class="input-group">
                <input type="tel" name="telefone" placeholder="(67) 99999-9999" value="<?= $usuario['telefone_usuario'] ?? '' ?>" readonly />
            </div>

            <!-- Campo senha, oculto inicialmente -->
            <div class="input-group" id="campo-senha" style="display:none; position: relative;">
                <input type="password" name="senha" placeholder="Senha" readonly />
                <button type="button" id="toggleSenha" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background:none; border:none; cursor:pointer;">
                    👁️
                </button>
            </div>

            <!-- Campo confirmar senha, oculto inicialmente -->
            <div class="input-group" id="campo-confirmar-senha" style="display:none; position: relative;">
                <input type="password" name="confirmar_senha" placeholder="Confirmar nova senha" readonly />
                <button type="button" id="toggleConfirmarSenha" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background:none; border:none; cursor:pointer;">
                    👁️
                </button>
            </div>

            <button type="button" class="btn-base" id="btnEditar">Editar</button>
            <button type="submit" class="btn-base" id="btnConfirmar" disabled>Confirmar</button>
            <button type="submit" onclick="pag('login')" class="btn-base vermelho" id="btnSair">Sair</button>
        </form>
    </main>
    <script type="module" src="./app/components/js/toast.js"></script>


    <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
        <script type="module">
            import { gerarToast } from './app/components/js/toast.js';
            gerarToast('<?= $_SESSION['mensagem_sucesso'] ?>', 'sucesso');
        </script>
        <?php unset($_SESSION['mensagem_sucesso']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['mensagem_erro'])): ?>
        <script type="module">
            import { gerarToast } from './app/components/js/toast.js';
            gerarToast('<?= $_SESSION['mensagem_erro'] ?>', 'erro');
        </script>
        <?php unset($_SESSION['mensagem_erro']); ?>
    <?php endif; ?>

    <script type="module">
        import { gerarToast } from './app/components/js/toast.js';
        const btnEditar = document.getElementById('btnEditar');
        const btnConfirmar = document.getElementById('btnConfirmar');
        const inputs = document.querySelectorAll('.form-container input:not([name="senha"]):not([name="confirmar_senha"])');
        const campoSenha = document.getElementById('campo-senha');
        const campoConfirmarSenha = document.getElementById('campo-confirmar-senha');

        const inputSenha = campoSenha.querySelector('input[name="senha"]');
        const inputConfirmarSenha = campoConfirmarSenha.querySelector('input[name="confirmar_senha"]');

        const toggleSenha = document.getElementById('toggleSenha');
        const toggleConfirmarSenha = document.getElementById('toggleConfirmarSenha');

        // Inicialmente só campos que não são senha ficam readonly e botão confirmar desabilitado
        inputs.forEach(input => input.setAttribute('readonly', true));
        inputSenha.setAttribute('readonly', true);
        inputConfirmarSenha.setAttribute('readonly', true);
        btnConfirmar.disabled = true;

        // Função para alternar mostrar/ocultar senha
        function togglePasswordVisibility(input, button) {
            if (input.type === "password") {
                input.type = "text";
                button.textContent = "🙈";
            } else {
                input.type = "password";
                button.textContent = "👁️";
            }
        }

        toggleSenha.addEventListener('click', () => {
            togglePasswordVisibility(inputSenha, toggleSenha);
        });

        toggleConfirmarSenha.addEventListener('click', () => {
            togglePasswordVisibility(inputConfirmarSenha, toggleConfirmarSenha);
        });

        btnEditar.addEventListener('click', () => {
            // Remove readonly dos inputs exceto senha que está oculto
            inputs.forEach(input => input.removeAttribute('readonly'));

            // Exibe os campos de senha
            campoSenha.style.display = 'flex';
            campoConfirmarSenha.style.display = 'flex';

            // Remove readonly dos campos de senha
            inputSenha.removeAttribute('readonly');
            inputConfirmarSenha.removeAttribute('readonly');

            btnConfirmar.disabled = false;

            gerarToast('Agora você pode editar seus dados.', 'info');
        });
    </script>
</body>

</html>
