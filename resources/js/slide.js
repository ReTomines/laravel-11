document.addEventListener('DOMContentLoaded', function () {
    const btnAddSlide = document.getElementById('btnAddSlide');
    const container = document.getElementById('containerSlides');
    const template = document.getElementById('slideTemplate');
    const placeholder = document.getElementById('placeholderSlide');

    btnAddSlide.addEventListener('click', function (e) {
        e.preventDefault();
        
        // Clonar o template
        const clone = template.content.cloneNode(true);
        
        // Adicionar ao container
        container.appendChild(clone);

        // Ocultar placeholder
        if (placeholder) {
            placeholder.style.display = 'none';
        }

        // Disparar evento personalizado para notificar que um novo slide foi adicionado
        const event = new CustomEvent('slideAdded', {
            detail: { slide: container.lastElementChild }
        });
        document.dispatchEvent(event);

        attachRemoveHandlers();
    });

    function attachRemoveHandlers() {
        const removeButtons = container.querySelectorAll('.btn-remove-slide');
        removeButtons.forEach(button => {
            button.onclick = function () {
                if (confirm('Tem certeza que deseja excluir este slide?')) {
                    const slideBlock = this.closest('.position-relative');
                    slideBlock.remove();

                    // Mostrar placeholder se não houver mais slides
                    if (container.querySelectorAll('.slide-container').length === 0 && placeholder) {
                        placeholder.style.display = 'block';
                    }
                }
            };
        });
    }
});