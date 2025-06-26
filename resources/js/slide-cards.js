document.addEventListener('DOMContentLoaded', function() {
    // Configurações dos cards
    const cardConfig = {
        count: 6,
        baseMarginTop: 126,
        cardHeight: 91,
        classes: 'cards fundo position-absolute start-50 translate-middle-x w-100 ms-1'
    };

    // Função principal para criar cards
    function createCardsForSlide(slideContainer) {
        if (!slideContainer) return;

        // Remove cards existentes para evitar duplicação
        const existingCards = slideContainer.querySelectorAll('.cards');
        existingCards.forEach(card => card.remove());

        // Cria novos cards
        for (let i = 0; i < cardConfig.count; i++) {
            const card = document.createElement('div');
            card.className = cardConfig.classes;
            card.style.height = `${cardConfig.cardHeight}px`;
            card.style.marginTop = `${cardConfig.baseMarginTop + (i * cardConfig.cardHeight)}px`;
            card.style.zIndex = '10';
            slideContainer.appendChild(card);
        }
    }

    // Verifica se um elemento é um container de slide
    function isSlideContainer(element) {
        return element.classList.contains('bg-black') && 
               element.style.width === '1280px' && 
               element.style.height === '720px';
    }

    // Inicializa todos os slides existentes
    function initializeExistingSlides() {
        document.querySelectorAll('.bg-black').forEach(container => {
            if (isSlideContainer(container)) {
                createCardsForSlide(container);
            }
        });
    }

    // Observador para novos slides adicionados dinamicamente
    const slidesObserver = new MutationObserver(function(mutations) {
        mutations.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                if (node.nodeType === 1) {
                    const potentialSlides = node.querySelectorAll ? node.querySelectorAll('.bg-black') : [];
                    potentialSlides.forEach(slide => {
                        if (isSlideContainer(slide)) {
                            createCardsForSlide(slide);
                        }
                    });
                    
                    if (isSlideContainer(node)) {
                        createCardsForSlide(node);
                    }
                }
            });
        });
    });

    // Inicia a observação
    slidesObserver.observe(document.body, {
        childList: true,
        subtree: true
    });

    // Processa slides iniciais
    initializeExistingSlides();
});