// Cria o elemento <footer>
const footer = document.createElement('footer');
footer.className = 'footer';

// Adiciona o conteúdo
footer.innerHTML = '<p>© 2025 Todos os direitos reservados.</p>';

// Insere o footer no final do <body>
document.addEventListener('DOMContentLoaded', () => {
  document.body.appendChild(footer);
});
