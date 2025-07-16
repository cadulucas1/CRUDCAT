document.addEventListener('DOMContentLoaded', () => {
    const formSuporte = document.querySelector('.form-suporte');

    if (!formSuporte) {
        console.warn('Formulário de suporte não encontrado. Verifique o seletor ".form-suporte".');
        return;
    }

    formSuporte.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(formSuporte);

        try {
            const response = await fetch('enviarSuporte', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.sucesso) {
                gerarToast(data.sucesso, 'sucesso');
                formSuporte.reset();
            } else {
                gerarToast(data.mensagem || 'Ocorreu um erro desconhecido.', 'erro');
            }
        } catch {
          return;  
        }
    });
});