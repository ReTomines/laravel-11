function criarDivs() {
    
    let divContainer = document.getElementById('s-1'); // Seleciona a div com id 'container'

    for (let i = 1; i <= 6; i++) {
        // Cria novas divs abaixo de 'pavimento'
        let novaDiv = document.createElement('div');
        novaDiv.classList.add('cards'); // Adiciona a classe 'cards'
        novaDiv.classList.add('fundo'); // Adiciona a classe 'fundo'

        // Definindo o ID corretamente usando template literals
        novaDiv.id = `f-${i}`; // Usando a interpolação correta de strings com backticks

        // Manipulando o estilo diretamente na nova div
        novaDiv.style.height = '91px';
        novaDiv.style.marginTop = (126 + (i - 1) * 92) + 'px';

        // Adiciona a nova div ao container
        divContainer.appendChild(novaDiv);
    }
}
criarDivs();

function adicionarSlide() {
        
    let main = document.getElementById('container'); // Seleciona a tag 'main'
    let novoSlide = document.createElement('div'); // Cria uma nova div
    novoSlide.classList.add('slides'); // Adiciona a classe 'slides'
    main.appendChild(novoSlide); // Adiciona a nova div ao container
}
adicionarSlide();