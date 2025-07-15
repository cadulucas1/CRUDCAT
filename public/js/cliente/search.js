import renderLojaCard from '../../../app/components/js/storeCard.js';

const lojas = [
    {
      nome_loja: 'Comper Itanhangá',
      endereco_loja: 'Rua das das',
      num_endereco_loja: '112',
      status: 'Aberto',
      horario_abertura: '12:00',
      horario_fechamento: '22:00'
    },
    {
      nome_loja: 'Supermercado Ponto Certo',
      endereco_loja: 'Av. Afonso Pena',
      num_endereco_loja: '1500',
      status: 'Fechado',
      horario_abertura: '08:00',
      horario_fechamento: '18:00'
    },
    {
      nome_loja: 'Mercado do Zé',
      endereco_loja: 'Rua do Comércio',
      num_endereco_loja: '305',
      status: 'Aberto',
      horario_abertura: '07:30',
      horario_fechamento: '20:00'
    },
    {
      nome_loja: 'Empório Central',
      endereco_loja: 'Travessa Bonita',
      num_endereco_loja: '87',
      status: 'Fechado',
      horario_abertura: '10:00',
      horario_fechamento: '22:00'
    },
    {
      nome_loja: 'Feira do Sul',
      endereco_loja: 'Rua Esperança',
      num_endereco_loja: '230',
      status: 'Aberto',
      horario_abertura: '09:00',
      horario_fechamento: '21:00'
    }
  ];
  
document.addEventListener('DOMContentLoaded', () => {
    const ul = document.querySelector('.search-results');
    if (!ul) return;

    ul.innerHTML = lojas.map(renderLojaCard).join('');
})