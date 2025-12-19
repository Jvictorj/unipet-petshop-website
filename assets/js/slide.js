/*-----------------------------------*\
  #SLIDER AUTOMÁTICO (HOME)
\*-----------------------------------*/

var cont = 1;

// Garante que o primeiro slide esteja marcado ao carregar
var radio1 = document.getElementById('radio1');
if(radio1) {
    radio1.checked = true;
}

// Inicia o intervalo de troca
setInterval(() => {
    proximaImg();
}, 7000);

function proximaImg() {
    cont++;

    if (cont > 4){
        cont = 1;
    }

    var radio = document.getElementById('radio' + cont);
    if(radio) {
        radio.checked = true;
    }
}