import renderLojaCard from '../../../app/components/js/storeCard.js';

window.renderLoja = function (idUser, idLoja) {
  window.location.href = `Loja?id_user=${idUser}&id_loja=${idLoja}`;
};

document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('search-lojas');
  const ul = document.querySelector('.search-results');
  const idUser = 1;

  if (!input || !ul) return;

  const buscarLojas = async (termo) => {
    try {
      const resp = await fetch(`search-lojas?query=${encodeURIComponent(termo)}`);
      if (!resp.ok) throw new Error('Erro na requisição');
      const lojas = await resp.json();

      ul.innerHTML = lojas.length
        ? lojas.map(renderLojaCard).join('')
        : '<li>Nenhuma loja encontrada.</li>';

    } catch (e) {
      console.error('Erro ao buscar lojas:', e);
      ul.innerHTML = '<li>Erro ao carregar resultados.</li>';
    }
  };

  let timeout;
  input.addEventListener('input', () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      const termo = input.value.trim();
      if (termo.length >= 2) {
        buscarLojas(termo);
      } else {
        ul.innerHTML = '';
      }
    }, 300);
  });

  ul.addEventListener('click', (e) => {
  const card = e.target.closest('.card-result');
  if (!card) return;

  const idLoja = card.dataset.idLoja;

  if (!idLoja) return;

  window.renderLoja(idUser, idLoja);
});

});
