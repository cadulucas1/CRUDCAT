document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('formCadastro');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    let valido = true;

    // Limpa mensagens anteriores
    const campos = ['nome', 'email', 'telefone', 'senha', 'confirmarSenha'];
    campos.forEach(id => {
      document.getElementById(`erro-${id}`).textContent = '';
    });

    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
    const senha = document.getElementById('senha').value;
    const confirmarSenha = document.getElementById('confirmarSenha').value;

    // Valida nome (mínimo 2 palavras)
    if (nome === '' || nome.split(' ').length < 2) {
      document.getElementById('erro-nome').textContent = 'Digite seu nome completo.';
      valido = false;
    }

    // Valida email (regex simples)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      document.getElementById('erro-email').textContent = 'E-mail inválido.';
      valido = false;
    }

    // Valida telefone (mínimo 10 dígitos numéricos)
    const telefoneLimpo = telefone.replace(/\D/g, '');
    if (telefoneLimpo.length < 10) {
      document.getElementById('erro-telefone').textContent = 'Telefone inválido.';
      valido = false;
    }

    // Valida senha
    if (senha.length < 6) {
      document.getElementById('erro-senha').textContent = 'A senha deve ter ao menos 6 caracteres.';
      valido = false;
    }

    // Valida confirmação de senha
    if (senha !== confirmarSenha) {
      document.getElementById('erro-confirmarSenha').textContent = 'As senhas não coincidem.';
      valido = false;
    }

    // Se tudo estiver ok
    if (valido) {
      form.submit(); // ou faça a requisição AJAX aqui, se preferir
    }
  });
});
