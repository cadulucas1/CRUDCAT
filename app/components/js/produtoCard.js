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

  export default renderProductCard;