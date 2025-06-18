document.addEventListener('DOMContentLoaded', function () {
    // Função segura para adicionar o eventListener ao botão
    function inicializarBotaoAdicionar() {
        const btnAdicionar = document.getElementById('btnAdicionar');

        if (!btnAdicionar) {
            console.warn('Botão #btnAdicionar não encontrado no DOM.');
            return;
        }

        btnAdicionar.addEventListener('click', function (e) {
            e.preventDefault();

            const activeTab = document.querySelector('.nav-link.active');
            let tab = 'vereadores'; // valor padrão

            if (activeTab?.id.includes('setores')) {
                tab = 'setores';
            } else if (activeTab?.id.includes('partidos')) {
                tab = 'partidos';
            }

            // Redireciona para a rota de criação com a aba correspondente
            window.location.href = `/videowall/create?tab=${tab}`;
        });
    }

    // Aguarda a renderização completa do conteúdo Blade
    const interval = setInterval(() => {
        if (document.getElementById('btnAdicionar')) {
            clearInterval(interval);
            inicializarBotaoAdicionar();
        }
    }, 100); // Tenta a cada 100ms até encontrar o botão

    // Opcional: para não ficar rodando infinitamente
    setTimeout(() => clearInterval(interval), 3000); // Para após 3s
});