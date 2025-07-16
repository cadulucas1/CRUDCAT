import renderLojaCard from '../../../app/components/js/storeCard.js';

// const sessions = [
//   {
//     category: 'babaui',
//     products: [
//       { id: 1, title: 'Camiseta Classic', image: 'https://placehold.co/400', status: 'Disponível', price: 80.00, oldPrice: 100.00 },
//       { id: 2, title: 'Tênis RunFast',  image: 'https://placehold.co/400', status: 'Disponível', price: 120.00, oldPrice: 150.00 }
//     ]
//   },
//   {
//     category: 'Loja Da silva',
//     products: [
//       { id: 3, title: 'Calça Jeans',   image: 'https://placehold.co/400', status: 'Disponível', price: 140.00 },
//       { id: 4, title: 'Jaqueta Wind',  image: 'https://placehold.co/400', status: 'Esgotado',   price: 200.00 }
//     ]
//   },
//   {
//     category: 'Loja ahuahuahuahua',
//     products: [
//       { id: 5, title: 'Mochila Trek',  image: 'https://placehold.co/400', status: 'Disponível', price: 180.00, oldPrice: 220.00 },
//       { id: 6, title: 'Boné Sport',    image: 'https://placehold.co/400', status: 'Disponível', price: 50.00  }
//     ]
//   }
// ];

// Mensagem para quem for mexer com o back disso: Caso não mantenhemos o sistema de "Disponível" e "Indisponível" apague a div "product-stauts"

function renderProductCard(p) {
  const isPromo = p.oldPrice && p.price < p.oldPrice;
  const discount = isPromo
    ? `-${Math.round((p.oldPrice - p.price) / p.oldPrice * 100)}%`
    : '';
  return `
    <div class="product-card f-column" data-id="${p.id}">
      ${isPromo
        ? `<div class="promo-value">${discount}</div>`
        : ''}
      <img src="${p.image}" alt="${p.title}">
      <div class="product-title">
        ${p.title}
        <div class="product-status">• ${p.status}</div>
      </div>
      <div class="product-value f-row">
        R$${p.price.toFixed(2).replace('.',',')}
        ${isPromo
          ? `<p>R$${p.oldPrice.toFixed(2).replace('.',',')}</p>`
          : ''}
      </div>
      <button class="btn-base">VER DETALHES</button>
    </div>
  `;
}

function renderSession(session) {
  return `
    <div class="product-session">
      <div class="product-session-title">${session.category}</div>
      <div class="scroll-wrapper">
        <div class="product-line">
          ${session.products.map(renderProductCard).join('')}
        </div>
      </div>
    </div>
  `;
}

// const lojas = [
//   {
//     id_loja: 1,
//     nome_loja: 'Comper Itanhangá',
//     endereco_loja: 'Rua das das',
//     num_endereco_loja: '112',
//     status: 'Aberto',
//     horario_abertura: '12:00',
//     horario_fechamento: '22:00'
//   },
//   {
//     id_loja: 2,
//     nome_loja: 'Supermercado Ponto Certo',
//     endereco_loja: 'Av. Afonso Pena',
//     num_endereco_loja: '1500',
//     status: 'Fechado',
//     horario_abertura: '08:00',
//     horario_fechamento: '18:00'
//   },
//   {
//     id_loja: 3,
//     nome_loja: 'Mercado do Zé',
//     endereco_loja: 'Rua do Comércio',
//     num_endereco_loja: '305',
//     status: 'Aberto',
//     horario_abertura: '07:30',
//     horario_fechamento: '20:00'
//   },
//   {
//     id_loja: 4,
//     nome_loja: 'Empório Central',
//     endereco_loja: 'Travessa Bonita',
//     num_endereco_loja: '87',
//     status: 'Fechado',
//     horario_abertura: '10:00',
//     horario_fechamento: '22:00'
//   },
//   {
//     id_loja: 5,
//     nome_loja: 'Feira do Sul',
//     endereco_loja: 'Rua Esperança',
//     num_endereco_loja: '230',
//     status: 'Aberto',
//     horario_abertura: '09:00',
//     horario_fechamento: '21:00'
//   }
// ];

window.renderLoja = function(idUser, idLoja) {
  window.location.href = `Loja?id_user=${idUser}&id_loja=${idLoja}`;
}

document.addEventListener('DOMContentLoaded', async () => {
  const container = document.getElementById('main-content');
  if (!container) return;

  const idUser = 1;
  let lojas = [];

  try {
    const response = await fetch(`getLojasSeguidas?id=${idUser}`);
    if (!response.ok) throw new Error('Erro ao buscar lojas');

    const dados = await response.json();

    if (dados.alerta) {
      container.innerHTML = `
        <div class="message-div">
          <h2>Aparentemente você não segue nenhuma loja.</h2>
          <p>Que tal seguir novas lojas e receber promoções exclusivas na sua região?</p>
          <button class="btn-base" onclick="pag('search')">
            <img src='./public/images/icons/icon_search.svg'>
            Pesquisar lojas
          </button>
        </div>
      `;
      return;
    }

    if (dados.erro) {
      container.innerHTML = `
        <div class="message-div">
          <h2>Conecte-se e encontre promoções nas suas lojas mais próximas ;)</h2>
          <button class="btn-base" onclick="pag('login')">
            <img src='./public/images/icons/icon_login_porta.svg'>
            Logar
          </button>
        </div>
      `;
      return;
    }


    lojas = Array.isArray(dados) ? dados : [];

  } catch (erro) {
    gerarToast(`Falha ao carregar lojas: ${erro.message}`, 'erro');
    return;
  }

  container.innerHTML = `
    <h2 class="title-store">
        Lojas seguidas
    </h2>
    <ul class="store-div">
      ${lojas.map(renderLojaCard).join('')}
    </ul>
  `;

  container.addEventListener('click', (e) => {
    const card = e.target.closest('.card-result');
  
    if (!card) return;
  
    const idLoja = card.dataset.idLoja;
    
    window.renderLoja(idUser, idLoja);
  });
});



