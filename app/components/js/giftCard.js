function renderGiftCard() {
  return `
    <li class="card-result-gift">
      <div class="image-gift">
        <img src="./public/images/fotos/presentinho.png" alt="Imagem presente">
      </div>
      <div class="dados-gift">
        <h3 class="gift-nome">
          <img src="./public/images/icons/icon_chapeu_festa.svg" alt="ícone de festa" class="gift-icone" id="icon-localizacao">
          NOVA TAREFA LIBERADA
        </h3>
        <p class="gift-descricao">
          Complete tarefas diáriamente para receber recompensas :)
        </p>
      </div>
    </li>
  `;
}

export default renderGiftCard;

const container = document.querySelector('.store-div');
if (container) {
  container.innerHTML += renderGiftCard();
} else {
  console.error("Container .store-div não encontrado!");
}
