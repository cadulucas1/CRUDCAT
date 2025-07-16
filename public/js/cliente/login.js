document.addEventListener('DOMContentLoaded', function () {
  const formLogin = document.getElementById('formLogin');

  if (formLogin) {
    formLogin.addEventListener('submit', function (e) {
      e.preventDefault();
      let valido = true;

      // Limpa mensagens anteriores
      document.getElementById('erro-loginEmail').textContent = '';
      document.getElementById('erro-loginSenha').textContent = '';

      const email = document.getElementById('loginEmail').value.trim();
      const senha = document.getElementById('loginSenha').value;

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailRegex.test(email)) {
        document.getElementById('erro-loginEmail').textContent = 'E-mail inválido.';
        valido = false;
      }

      if (senha === '') {
        document.getElementById('erro-loginSenha').textContent = 'Digite sua senha.';
        valido = false;
      }

      if (valido) {
        formLogin.submit(); // ou AJAX login
      }
    });
  }
});
