document.addEventListener('DOMContentLoaded', function () {
  const formLogin = document.getElementById('formLogin');

  if (formLogin) {
    formLogin.addEventListener('submit', function (e) {
      e.preventDefault();
      let valido = true;

      const emailInput = document.getElementById('loginEmail');
      const senhaInput = document.getElementById('loginSenha');
      emailInput.classList.remove('input-erro');
      senhaInput.classList.remove('input-erro');

      const email = emailInput.value.trim();
      const senha = senhaInput.value;

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailRegex.test(email)) {
        gerarToast('Email inválido', 'erro');
        emailInput.classList.add('input-erro');
        valido = false;
      }

      if (senha === '') {
        gerarToast('Digite sua senha', 'erro');
        senhaInput.classList.add('input-erro');
        valido = false;
      }

      if (valido) {
        gerarToast('Login realizado com sucesso!', 'sucesso');

        
        setTimeout(() => {
          window.location.href = 'Loja'; 
        }, 3000);
      }
    });
  }
});
