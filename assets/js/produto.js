/*-----------------------------------*\
  #PÁGINA DE PRODUTO (Lógica Corrigida)
\*-----------------------------------*/

// Variáveis para a imagem principal e miniaturas
// OBS: Certifique-se que no HTML o ID é 'MainImg' e a classe das miniaturas é 'thumbnail-img'
var MainImg = document.getElementById('MainImg');
var thumbnail_img = document.getElementsByClassName('thumbnail-img');

// Função para mostrar a imagem correspondente quando uma miniatura é clicada
function Mostrar_Imagem(index) {
    if(MainImg && thumbnail_img[index]) {
        MainImg.src = thumbnail_img[index].src;
    }
}

// Função para navegar para a imagem anterior
function Imagem_Anterior() {
    if (!MainImg || !thumbnail_img.length) return;

    // Encontra qual é a imagem atual
    let currentIndex = Array.from(thumbnail_img).findIndex(img => img.src === MainImg.src);
    
    // Se não achar (ex: carregamento inicial), assume 0
    if (currentIndex === -1) currentIndex = 0;

    // Calcula a anterior (lógica circular)
    currentIndex = (currentIndex - 1 + thumbnail_img.length) % thumbnail_img.length;
    
    MainImg.src = thumbnail_img[currentIndex].src;
}

// Função para navegar para a próxima imagem
function Proxima_Imagem() {
    if (!MainImg || !thumbnail_img.length) return;

    let currentIndex = Array.from(thumbnail_img).findIndex(img => img.src === MainImg.src);
    
    if (currentIndex === -1) currentIndex = 0;

    // Calcula a próxima (lógica circular)
    currentIndex = (currentIndex + 1) % thumbnail_img.length;
    
    MainImg.src = thumbnail_img[currentIndex].src;
}

// Função para diminuir o valor do input
function Diminuir_Valor() {
    var input = document.getElementById('btn-input');
    var hiddenInput = document.getElementById('form-qtd');
    
    if(input) {
        var currentValue = parseInt(input.value, 10);
        if (!isNaN(currentValue) && currentValue > 1) {
            input.value = currentValue - 1;
            if(hiddenInput) hiddenInput.value = input.value;
        }
    }
}

// Função para aumentar o valor do input
function Aumentar_Valor() {
    var input = document.getElementById('btn-input');
    var hiddenInput = document.getElementById('form-qtd');

    if(input) {
        var currentValue = parseInt(input.value, 10);
        if (!isNaN(currentValue)) {
            input.value = currentValue + 1;
            if(hiddenInput) hiddenInput.value = input.value;
        }
    }
}

// Função para alternar o estado visual do botão de favorito
function Btn_Favorito() {
    var favBtn = document.querySelector('.fav-btn');
    if(favBtn) {
        // Apenas visual, a lógica real é feita pelo PHP/Link
        const icon = favBtn.querySelector('i');
        if(icon) {
            if(icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                icon.style.color = 'red';
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                icon.style.color = 'gray';
            }
        }
    }
}