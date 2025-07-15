function renderLojaCard(l) {
    return `
    <li class="card-result">
        <div class="image-loja">
            <img src="https://placehold.co/400">
        </div>
        <div class="dados-loja">
        <h3 class="loja-nome">
            ${l.nome_loja}
        </h3>
        <p class="loja-endereco">
            <img src="./public/images/icons/icon_localizacao.svg" alt="ícone localização" class="dados-icone" id="icon-localizacao">
            ${l.endereco_loja}, ${l.num_endereco_loja}
        </p>
        <p class="loja-status">
            <img src="./public/images/icons/icon_status.svg" alt="ícone status" class="dados-icone" id="icon-status">
            Status: <span class="status-${l.status}">${l.status}</span>
        </p>
        <p class="loja-horario">
            <img src="./public/images/icons/icon_relogio.svg" alt="ícone horário" class="dados-icone" id="icon-horario">
            Fechado das ${l.horario_abertura}h às ${l.horario_fechamento}h
        </p>
        </div>
    </li>
    `
}

export default renderLojaCard;