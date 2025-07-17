document.addEventListener('DOMContentLoaded', () => {
  const tarefasContainer = document.querySelector('.tarefas-div');
  if (!tarefasContainer) return;

  const tarefas = JSON.parse(tarefasContainer.dataset.tarefas || '[]');

  tarefas.forEach(tarefa => {
    const tarefaDiv = document.createElement('div');
    tarefaDiv.classList.add(`tarefa-${tarefa.id_tarefa}`);
    tarefaDiv.classList.add('tarefa-item');

    tarefaDiv.innerHTML = `
      <h3 class="tarefa-nome">${tarefa.nome_tarefa}</h3>
      <p class="tarefa-descricao">${tarefa.descricao}</p>
      <p class="tarefa-pontos">Pontos: ${tarefa.pontos_tarefa}</p>
    `;

    const botao = document.createElement('button');
    botao.classList.add('btn-base');
    botao.dataset.id = tarefa.id_tarefa;

    if (tarefa.situacao === 'Concluída') {
      botao.textContent = 'Realizada';
      botao.disabled = true;
      botao.classList.add('disabled');
    } else {
      botao.textContent = 'Realizar tarefa';

      botao.addEventListener('click', async () => {
        const idTarefa = botao.dataset.id;
        let idUser = 1;

        try {
          const resposta = await fetch('realizar-tarefa', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_tarefa: idTarefa, id_user: idUser })
          });

          const resultado = await resposta.json();

          if (!resposta.ok || !resultado.success) {
            throw new Error(resultado.message || 'Erro ao realizar a tarefa.');
          }

          // Atualiza o botão
          botao.textContent = 'Realizada';
          botao.disabled = true;
          botao.classList.add('disabled');

          gerarToast('Tarefa realizada com sucesso!', 'sucesso');

        } catch (erro) {
          gerarToast(erro.message || 'Erro ao realizar tarefa.', 'erro');
          console.log(error.message);        }
      });
    }

    tarefaDiv.appendChild(botao);
    tarefasContainer.appendChild(tarefaDiv);
  });
});
