document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formLogin');
  const emailInput = document.getElementById('loginEmail');
  const senhaInput = document.getElementById('loginSenha');

  const erroEmail = document.getElementById('erro-loginEmail');
  const erroSenha = document.getElementById('erro-loginSenha');

  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Limpa mensagens anteriores
    erroEmail.textContent = '';
    erroSenha.textContent = '';

    const email = emailInput.value.trim();
    const senha = senhaInput.value.trim();

    let erro = false;

    // Validação básica
    if (!email) {
      erroEmail.textContent = 'Informe seu e-mail.';
      erro = true;
    }

    if (!senha) {
      erroSenha.textContent = 'Informe sua senha.';
      erro = true;
    }

    if (erro) return;

    try {
      const formData = new FormData();
      formData.append('email', email);
      formData.append('senha', senha);

  const response = await fetch('/CRUDCAT/login', {
  method: 'POST',
  body: formData
  });

  const contentType = response.headers.get("content-type");

  if (!response.ok || !contentType.includes("application/json")) {
    throw new Error("Resposta não é JSON ou status inválido");
  }

  const result = await response.json();


      if (result.success) {
        window.location.href = result.redirect;
      } else {
        erroSenha.textContent = result.message || 'Erro ao fazer login.';
      }
    } catch (error) {
      erroSenha.textContent = 'Erro na conexão com o servidor.';
    }
  });
});