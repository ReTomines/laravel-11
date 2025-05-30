document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('selectPartido');
    const logoImg = document.getElementById('logoPartido');

    if (select && logoImg) {
        select.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const logoUrl = selectedOption.getAttribute('data-logo');

            console.log('Selecionado:', selectedOption.text);
            console.log('Logo URL:', logoUrl);

            if (logoUrl) {
                logoImg.src = logoUrl;
                logoImg.style.display = 'block';
            } else {
                logoImg.src = '';
                logoImg.style.display = 'none';
            }
        });
    } else {
        console.log('Select ou logoImg não encontrados');
    }
});
