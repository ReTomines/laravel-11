class SlideManager {
    constructor() {
        this.container = document.getElementById('containerSlides');
        this.template = document.getElementById('slideTemplate');
        this.placeholder = document.getElementById('placeholderSlide');
        this.vereadores = window.vereadoresData;
        
        this.initEvents();
        this.initExistingSlides();
    }

    initEvents() {
        document.getElementById('btnAddSlide')?.addEventListener('click', (e) => {
            e.preventDefault();
            this.addSlide();
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('.btn-remove-slide')) {
                this.removeSlide(e.target.closest('.slide-container'));
            }
        });
    }

    addSlide(pavimento = 3) {
        const clone = this.template.content.cloneNode(true);
        const slideElement = clone.querySelector('.slide-container');
        slideElement.dataset.pavimento = pavimento;
        
        this.container.appendChild(clone);
        this.placeholder.style.display = 'none';
        
        this.initSlide(this.container.lastElementChild);
    }

    removeSlide(slideElement) {
        if (confirm('Tem certeza que deseja excluir este slide?')) {
            slideElement.remove();
            if (!this.container.querySelector('.slide-container')) {
                this.placeholder.style.display = 'block';
            }
        }
    }

    initSlide(slideElement) {
        const pavimento = slideElement.dataset.pavimento;
        const slideContent = slideElement.querySelector('.slide-content');
        
        this.createCards(slideContent);
        this.populateSlide(slideElement, pavimento);
    }

    createCards(container) {
        const cardHeight = 91;
        const baseMarginTop = 126;
        
        for (let i = 0; i < 6; i++) {
            const card = document.createElement('div');
            card.className = `card-vereador position-absolute start-50 translate-middle-x w-100 ms-1 card-${i+1}`;
            card.style.height = `${cardHeight}px`;
            card.style.marginTop = `${baseMarginTop + (i * cardHeight)}px`;
            card.style.zIndex = '10';
            container.appendChild(card);
        }
    }

    populateSlide(slideElement, pavimento) {
        const vereadores = this.vereadores[pavimento] || [];
        const titleElement = slideElement.querySelector('.slide-title');
        const cards = slideElement.querySelectorAll('.card-vereador');

        titleElement.textContent = `EDIFÍCIO GENERAL EURICO GÁSPAR DUTRA (EDIFÍCIO ANEXO) | ${pavimento}ª PAVIMENTO`;
        
        vereadores.forEach((vereador, index) => {
            if (cards[index]) {
                cards[index].textContent = `${vereador.nome_politico} | ${vereador.sala}`;
                cards[index].style.color = '#FFFFFF';
                cards[index].style.textAlign = 'center';
                cards[index].style.paddingTop = '30px';
                cards[index].style.fontWeight = 'bold';
                cards[index].style.fontSize = '18px';
            }
        });
    }

    initExistingSlides() {
        this.container.querySelectorAll('.slide-container').forEach(slide => {
            this.initSlide(slide);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new SlideManager();
});