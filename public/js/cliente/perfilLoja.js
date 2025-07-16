import renderProductCard from '../../../app/components/js/produtoCard.js';

document.addEventListener('DOMContentLoaded', () => {
  // 2.1 RENDERIZAÇÃO DOS PRODUTOS
  const container = document.getElementById('produtos-container');
  if (!container) return;

  let produtosArr;
  try {
    produtosArr = JSON.parse(container.dataset.produtos);
    console.log(JSON.parse(container.dataset.produtos));

  } catch (err) {
    console.error('JSON inválido em data-produtos:', err);
    return;
  }

  // Gera o HTML dos cards e injeta UMA única vez
  container.innerHTML = produtosArr.map(prod => {
    const hasPromo = prod.percentual_desconto > 0;
    return renderProductCard({
      id: prod.id_produto,
      title: prod.nome_produto,
      price: prod.preco_venda_loja,
      oldPrice: hasPromo ? prod.preco_original : 0,
      status: prod.quantidade > 0 ? 'Disponível' : 'Indisponível'
    });
  }).join('');

  // 2.2 LÓGICA DO CHECKBOX “SEGUIR / PARAR DE SEGUIR”
  const checkbox = document.getElementById('perfil_loja_heart');
  if (!checkbox) return;

  // Pega id_loja do atributo data-id-loja
  const idLoja = checkbox.dataset.idLoja;
  // Pega id_user da URL
  const params = new URLSearchParams(window.location.search);
  const idUser = params.get('id_user');

  if (!idUser || !idLoja) {
    gerarToast('Parâmetros de usuário ou loja não encontrados.', 'erro');
    return;
  }

  checkbox.addEventListener('change', async () => {
    const seguindo = checkbox.checked;

    try {
      const response = await fetch('toggleSeguirLoja', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          id_user: parseInt(idUser, 10),
          id_loja: parseInt(idLoja, 10),
          seguir:  seguindo
        })
      });

      const result = await response.json();

      if (!response.ok) {
        // erro de negócio (400/500)
        gerarToast(result.mensagem || 'Falha ao atualizar status', 'erro');
        // reverte estado visual
        checkbox.checked = !seguindo;
        return;
      }

      // sucesso
      gerarToast(result.mensagem, 'sucesso');
    } catch (err) {
      // erro de rede ou JSON inválido
      console.error('Erro no fetch:', err);
      gerarToast('Não foi possível atualizar o status. Tente novamente.', 'erro');
      checkbox.checked = !seguindo;
    }
  });
});
