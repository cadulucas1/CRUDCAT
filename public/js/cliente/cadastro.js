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

    const nome           = document.getElementById('nome');
    const email          = document.getElementById('email');
    const telefone       = document.getElementById('telefone');
    const senha          = document.getElementById('senha');
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

    if (!valido) {
      return; 
    }

    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
    })
    .then(response => response.json())
    .then(json => {
      if (json.success) {
        gerarToast(json.message, 'sucesso');
        setTimeout(() => {
          window.location.href = json.redirect;
        }, 2000);
      } else {
        gerarToast(json.message, 'erro');
        // destaca campo específico, se informado
        if (json.field) {
          const fld = document.getElementById(json.field);
          if (fld) fld.classList.add('input-erro');
        }
      }
    })
    .catch(err => {
      console.error('Erro na requisição:', err);
      gerarToast('Erro de rede. Tente novamente.', 'erro');
    });
  });
});
