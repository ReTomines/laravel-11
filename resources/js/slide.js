document.addEventListener('DOMContentLoaded', function () {
    const btnAddSlide = document.getElementById('btnAddSlide');
    const container = document.getElementById('containerSlides');
    const template = document.getElementById('slideTemplate');
    const placeholder = document.getElementById('placeholderSlide');

    btnAddSlide.addEventListener('click', function (e) {
        e.preventDefault();
        const clone = template.content.cloneNode(true);
        container.appendChild(clone);

        // Ocultar placeholder se existir
        if (placeholder) {
            placeholder.style.display = 'none';
        }

        attachRemoveHandlers();
    });

    function attachRemoveHandlers() {
        const removeButtons = container.querySelectorAll('.btn-remove-slide');
        removeButtons.forEach(button => {
            button.onclick = function () {
                if (confirm('Tem certeza que deseja excluir este slide?')) {
                    const slideBlock = this.closest('.position-relative');
                    slideBlock.remove();

                    // Se não houver mais slides, mostra o placeholder
                    if (container.querySelectorAll('.position-relative').length === 0 && placeholder) {
                        placeholder.style.display = 'block';
                    }
                }
            };
        });
    }
});