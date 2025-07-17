async function comprarCupom(idCliente, idCupom, btn) {
  try {
    const url = `comprar-cupom?cliente=${idCliente}&cupom=${idCupom}`;
    const resp = await fetch(url, { method: 'POST' });
    const pontos = document.getElementById('pontos-user');
    
    if (!resp.ok) {
      const errText = await resp.text();
      console.error('Erro no resgate:', errText);
      gerarToast('Não foi possível resgatar o cupom. Tente novamente.', 'erro');
      return;
    }

    respJson = await resp.json(); 
    btn.textContent = 'Cupom Resgatado';
    btn.disabled = true;
    btn.classList.add('disabled');
    pontos.innerHTML = respJson.saldo;
  } catch (e) {
    console.error('Erro na requisição:', e);
    gerarToast('Erro de conexão. Verifique sua internet e tente de novo.', 'erro');
  }
}
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('render-cupons');
  const cuponsJson = container.getAttribute('data-cupons[]');
  let cupons;
  let idCliente = 1; 
  try {
    cupons = JSON.parse(cuponsJson);
  } catch (e) {
    console.error('Erro ao parsear cupons:', e);
    return;
  }

  cupons.forEach(cupom => {
    const card = document.createElement('div');
    card.classList.add(`card-cupom`, 'card-cupom');
    
    const valorEl = document.createElement('div');
    valorEl.classList.add('card-cupom-valor');

    const imgIcon = document.createElement('img');
    imgIcon.classList.add('ticket-icon');
    imgIcon.src = './public/images/icons/icon_ticket2.svg'; 
    imgIcon.alt = 'Ícone de ticket';

    valorEl.appendChild(imgIcon);

    const texto = document.createTextNode(` ${cupom.valor_desconto}% OFF`);
    valorEl.appendChild(texto);

    valorEl.style.fontSize = '1.5em';
    valorEl.style.fontWeight = 'bold';
    card.appendChild(valorEl);

    const codigoEl = document.createElement('div');
    codigoEl.classList.add('card-cupom-codigo');
    codigoEl.textContent = cupom.codigo_cupom;
    card.appendChild(codigoEl);

    const descEl = document.createElement('p');
    descEl.classList.add('card-cupom-descricao');
    descEl.textContent = cupom.descricao;
    card.appendChild(descEl);

    const valorCupom = document.createElement('div');
    valorCupom.classList.add('cupom-valor');
    valorCupom.textContent = `Valor do cupom: ${cupom.valor_pontos}pt`;
    card.appendChild(valorCupom);

    const btn = document.createElement('button');
    btn.classList.add('btn-base', 'card-cupom-btn');
    if (cupom.adquirido) {
        btn.textContent = 'Cupom Resgatado';
        btn.disabled = true;
        btn.classList.add('disabled');
    } else {
        btn.textContent = 'Comprar Cupom';
        btn.disabled = false;
        btn.addEventListener('click', () => {
        comprarCupom(idCliente, cupom.id_cupom, btn);
        });
    }
    card.appendChild(btn);

    container.appendChild(card);
  });
});
