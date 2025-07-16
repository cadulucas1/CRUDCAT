
document.addEventListener('DOMContentLoaded', () => {
    const formSuporte = document.querySelector('.form-suporte');

    if (!formSuporte) {
        console.warn('Formulário de suporte não encontrado. Verifique o seletor ".form-suporte".');
        return;
    }

    const submitButton = formSuporte.querySelector('button[type="submit"]');
    const originalButtonHtml = submitButton.innerHTML;

    formSuporte.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(formSuporte);
        submitButton.disabled = true;
        submitButton.textContent = 'Enviando...';

        try {
           
            const response = await fetch('enviarSuporte', {
                method: 'POST',
                body: formData
            });

            
            const data = await response.json();

            if (response.ok && data.sucesso) {
                gerarToast(data.sucesso, 'sucesso');
                submitButton.disabled = false;
                submitButton.innerHTML = `
                    ENVIAR MENSAGEM
                    <img src="./public/images/icons/icon_enviar_mensagem.svg" alt="aviaozinho" class="icon-mensagem">
                `;
                formSuporte.reset();
            } else {
                gerarToast(data.mensagem || 'Ocorreu um erro desconhecido.', 'erro');

            }
        } catch {
            submitButton.disabled = false; 
            submitButton.innerHTML = originalButtonHtml; 
        }
    });
});
