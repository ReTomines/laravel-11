document.addEventListener('DOMContentLoaded', function() {
    const cardConfig = {
        count: 6,
        baseMarginTop: 126,
        cardHeight: 91,
        classes: 'cards fundo position-absolute start-50 translate-middle-x w-100 ms-1'
    };

    function createCardsForSlide(slideContainer) {
        if (!slideContainer) return;

        // Limpar cards existentes
        const existingCards = slideContainer.querySelectorAll('.cards');
        existingCards.forEach(card => card.remove());

        // Criar novos cards
        for (let i = 0; i < cardConfig.count; i++) {
            const card = document.createElement('div');
            card.className = cardConfig.classes;
            card.style.height = `${cardConfig.cardHeight}px`;
            card.style.marginTop = `${cardConfig.baseMarginTop + (i * cardConfig.cardHeight)}px`;
            card.style.zIndex = '10';
            slideContainer.appendChild(card);
        }
    }

    // Ouvinte para novos slides
    document.addEventListener('slideAdded', function(e) {
        const slideContainer = e.detail.slide.querySelector('.bg-black');
        if (slideContainer) {
            createCardsForSlide(slideContainer);
        }
    });

    // Inicializar slides existentes
    document.querySelectorAll('.bg-black').forEach(container => {
        createCardsForSlide(container);
    });
});