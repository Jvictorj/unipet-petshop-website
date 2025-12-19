/*-----------------------------------*\
  #MODAL DO CARRINHO
\*-----------------------------------*/

const openModalButton = document.querySelector("#open-modal");
const closeModalButton = document.querySelector("#close-modal");
const modal = document.querySelector("#modal");
const fade = document.querySelector("#fade");
const botao = document.querySelector(".btnmodal");

// Elementos Mobile (se existirem no HTML)
const openModalButtonMobile = document.querySelector("#open-modal-mobile");
const closeModalButtonMobile = document.querySelector("#close-modal-mobile");
const modalMobile = document.querySelector("#modal-mobile");
const fadeMobile = document.querySelector("#fade-mobile");
const botaoMobile = document.querySelector(".btnmodal-mobile");

const toggleModal = () => {
    // Alterna a classe 'hide' para mostrar/esconder
    [modal, fade].forEach((el) => {
        if(el) el.classList.toggle("hide");
    });
    
    // Se tiver modal mobile separado
    if (modalMobile && fadeMobile) {
        [modalMobile, fadeMobile].forEach((el) => el.classList.toggle("hide"));
    }
};

// Adiciona eventos de clique aos elementos existentes
[openModalButton, closeModalButton, fade, botao, openModalButtonMobile, closeModalButtonMobile, fadeMobile, botaoMobile].forEach((el) => {
    if (el) {
        el.addEventListener("click", () => toggleModal());
    }
});