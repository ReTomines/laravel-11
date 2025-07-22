document.addEventListener('DOMContentLoaded', function() {
    // Carregar dados dos vereadores
    const vereadoresData = JSON.parse(document.getElementById('vereadoresData').textContent);
    
    // Configurações dos slides
    const slideConfig = {
        titles: {
            3: 'EDIFÍCIO GENERAL EURICO GÁSPAR DUTRA (EDIFÍCIO ANEXO) | 3ª PAVIMENTO',
            4: 'EDIFÍCIO GENERAL EURICO GÁSPAR DUTRA (EDIFÍCIO ANEXO) | 4ª PAVIMENTO'
        }
    };

    // Função para preencher um slide com dados
    function populateSlide(slideElement, pavimento) {
        const vereadores = pavimento === 3 ? vereadoresData.pavimento3 : vereadoresData.pavimento4;
        const slideContainer = slideElement.querySelector('.bg-black');
        
        if (!slideContainer) return;

        // Definir título
        const tituloElement = slideContainer.querySelector('#titulo');
        if (tituloElement) {
            tituloElement.textContent = slideConfig.titles[pavimento];
            tituloElement.style.color = 'white';
            tituloElement.style.textAlign = 'center';
            tituloElement.style.paddingTop = '10px';
            tituloElement.style.fontWeight = 'bold';
        }

        // Definir pavimento (se necessário)
        const pavimentoElement = slideContainer.querySelector('#pavimento');
        if (pavimentoElement) {
            pavimentoElement.textContent = '';
        }

        // Preencher cards
        const cards = slideContainer.querySelectorAll('.cards');
        vereadores.forEach((vereador, index) => {
            if (cards[index]) {
                cards[index].textContent = `${vereador.nome_politico} | ${vereador.sala}`;
                cards[index].style.color = 'white';
                cards[index].style.textAlign = 'center';
                cards[index].style.paddingTop = '30px';
                cards[index].style.fontWeight = 'bold';
            }
        });
    }

    // Ouvinte para novos slides adicionados
    document.addEventListener('slideAdded', function(e) {
        setTimeout(() => {
            populateSlide(e.detail.slide, 3); // Preencher com 3º pavimento por padrão
        }, 100);
    });

    // Preencher slides existentes (se houver)
    document.querySelectorAll('.slide-container').forEach(slide => {
        populateSlide(slide, 3);
    });
});