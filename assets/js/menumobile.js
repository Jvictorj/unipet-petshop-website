/*-----------------------------------*\
  #MENU E NAVEGAÇÃO
\*-----------------------------------*/
'use strict';

/**
 * Função utilitária para adicionar eventos
 */
const addEventOnElem = function (elem, type, callback) {
  if (elem.length > 1) {
    for (let i = 0; i < elem.length; i++) {
      elem[i].addEventListener(type, callback);
    }
  } else if (elem) {
    elem.addEventListener(type, callback);
  }
}

/**
 * Navbar Toggle (Mobile)
 * Nota: Certifique-se que no HTML os elementos tenham os atributos: 
 * data-nav-toggler, data-navbar e data-nav-link
 */
const navToggler = document.querySelector("[data-nav-toggler]");
const navbar = document.querySelector("[data-navbar]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");

const toggleNavbar = function () {
  if(navbar && navToggler) {
      navbar.classList.toggle("active");
      navToggler.classList.toggle("active");
  }
}

if(navToggler) {
    addEventOnElem(navToggler, "click", toggleNavbar);
}

const closeNavbar = function () {
  if(navbar && navToggler) {
      navbar.classList.remove("active");
      navToggler.classList.remove("active");
  }
}

if(navbarLinks.length > 0) {
    addEventOnElem(navbarLinks, "click", closeNavbar);
}

/**
 * Header Ativo ao rolar (Scroll) e Botão Voltar ao Topo
 */
const header = document.querySelector("[data-header]"); // Adicione data-header no seu <header>
const backTopBtn = document.querySelector("#link-topo"); // Ou [data-back-top-btn]

const activeElemOnScroll = function () {
  if (window.scrollY > 100) {
    if(header) header.classList.add("active");
    if(backTopBtn) backTopBtn.classList.add("active");
  } else {
    if(header) header.classList.remove("active");
    if(backTopBtn) backTopBtn.classList.remove("active");
  }
}

window.addEventListener("scroll", activeElemOnScroll);