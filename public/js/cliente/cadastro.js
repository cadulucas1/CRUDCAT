document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('formCadastro');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    let valido = true;

    const campos = ['nome', 'email', 'telefone', 'senha', 'confirmarSenha'];

    campos.forEach(id => {
      const input = document.getElementById(id);
      input.classList.remove('input-erro');
    });

    const nome = document.getElementById('nome');
    const email = document.getElementById('email');
    const telefone = document.getElementById('telefone');
    const senha = document.getElementById('senha');
    const confirmarSenha = document.getElementById('confirmarSenha');

    if (nome.value.trim() === '' || nome.value.trim().split(' ').length < 2) {
      gerarToast('Digite seu nome completo.', 'erro');
      nome.classList.add('input-erro');
      valido = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.trim())) {
      gerarToast('E-mail inválido.', 'erro');
      email.classList.add('input-erro');
      valido = false;
    }

    const telefoneLimpo = telefone.value.replace(/\D/g, '');
    if (telefoneLimpo.length < 10) {
      gerarToast('Telefone inválido.', 'erro');
      telefone.classList.add('input-erro');
      valido = false;
    }

    if (senha.value.length < 6) {
      gerarToast('A senha deve ter ao menos 6 caracteres.', 'erro');
      senha.classList.add('input-erro');
      valido = false;
    }

    if (senha.value !== confirmarSenha.value) {
      gerarToast('As senhas não coincidem.', 'erro');
      confirmarSenha.classList.add('input-erro');
      valido = false;
    }

   
    if (valido) {
      gerarToast('Cadastro enviado com sucesso!', 'sucesso');


      setTimeout(() => {
        window.location.href = 'login'; 
      }, 3000);
    }
  });
});
