const btnEditar = document.getElementById('btnEditar');
const btnConfirmar = document.getElementById('btnConfirmar');
const inputs = document.querySelectorAll('.form-container input');
const campoConfirmarSenha = document.getElementById('campo-confirmar-senha');
const form = document.querySelector('.form-container');

// Inicia os campos como readonly e botão confirmar desabilitado
inputs.forEach(input => input.setAttribute('readonly', true));
btnConfirmar.disabled = true;
campoConfirmarSenha.style.display = 'none';

// Função para validar telefone (Brasil - aceita parênteses, espaços, hífens)
function validarTelefone(tel) {
    const numeros = tel.replace(/\D/g, '');
    if (numeros.length !== 10 && numeros.length !== 11) {
        return false;
    }
    const ddd = numeros.substring(0, 2);
    if (!/^[1-9]{2}$/.test(ddd)) {
        return false;
    }
    return true;
}

// Ao clicar em "Editar"
btnEditar.addEventListener('click', () => {
    inputs.forEach(input => input.removeAttribute('readonly'));
    campoConfirmarSenha.style.display = 'flex';
    btnConfirmar.disabled = false;
    gerarToast('Agora você pode editar seus dados.', 'info');
});

// Ao enviar o formulário (clicar em Confirmar)
form.addEventListener('submit', (e) => {
    e.preventDefault(); // Evita envio real para teste

    const nome = form.querySelector('input[name="nome"]').value.trim();
    const email = form.querySelector('input[name="email"]').value.trim();
    const telefone = form.querySelector('input[name="telefone"]').value.trim();
    const senha = form.querySelector('input[name="senha"]').value;
    const confirmarSenha = form.querySelector('input[name="confirmar_senha"]').value;

    // Remove bordas de erro antes da validação
    inputs.forEach(input => input.classList.remove('input-error'));

    // Valida campos obrigatórios básicos
    if (!nome || !email || !telefone) {
        gerarToast('Por favor, preencha todos os campos obrigatórios.', 'aviso');
        if (!nome) form.querySelector('input[name="nome"]').classList.add('input-error');
        if (!email) form.querySelector('input[name="email"]').classList.add('input-error');
        if (!telefone) form.querySelector('input[name="telefone"]').classList.add('input-error');
        return;
    }

    // Validação do telefone
    if (!validarTelefone(telefone)) {
        gerarToast('Telefone inválido. Informe um número com DDD válido e 10 ou 11 dígitos.', 'erro');
        form.querySelector('input[name="telefone"]').classList.add('input-error');
        return;
    }

    // Validação obrigatória da senha e confirmação
    if (!senha || !confirmarSenha) {
        gerarToast('Por favor, preencha a senha e confirme para salvar.', 'aviso');
        form.querySelector('input[name="senha"]').classList.add('input-error');
        form.querySelector('input[name="confirmar_senha"]').classList.add('input-error');
        return;
    }

    if (senha !== confirmarSenha) {
        gerarToast('As senhas não coincidem.', 'erro');
        form.querySelector('input[name="senha"]').classList.add('input-error');
        form.querySelector('input[name="confirmar_senha"]').classList.add('input-error');
        return;
    }

    if (senha.length < 6) {
        gerarToast('A senha deve ter no mínimo 6 caracteres.', 'aviso');
        form.querySelector('input[name="senha"]').classList.add('input-error');
        return;
    }

    // Se tudo passar
    gerarToast('Perfil atualizado com sucesso!', 'sucesso');

    // Aqui você pode fazer a chamada AJAX para salvar no backend, por exemplo
});
