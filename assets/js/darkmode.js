/*-----------------------------------*\
  #DARK MODE & MENU MOBILE
\*-----------------------------------*/

document.addEventListener('DOMContentLoaded', function() {
    
    // --- DARK MODE ---
    const darkBtn = document.getElementById('icon-dark-mode');
    const lightBtn = document.getElementById('icon-light-mode');
    
    // Mobile (se houver IDs diferentes)
    const darkBtnMob = document.getElementById('icon-dark-mode-mobile');
    const lightBtnMob = document.getElementById('icon-light-mode-mobile');

    // Função para ativar modo escuro
    function enableDarkMode() {
        document.body.classList.add('dark-theme');
        localStorage.setItem('dark-theme', '1');
    }

    // Função para desativar modo escuro
    function disableDarkMode() {
        document.body.classList.remove('dark-theme');
        localStorage.removeItem('dark-theme');
    }

    // Carregar preferência ao iniciar
    if (localStorage.getItem('dark-theme') === '1') {
        enableDarkMode();
    }

    // Eventos Desktop
    if(darkBtn) darkBtn.onclick = enableDarkMode;
    if(lightBtn) lightBtn.onclick = disableDarkMode;

    // Eventos Mobile
    if(darkBtnMob) darkBtnMob.onclick = enableDarkMode;
    if(lightBtnMob) lightBtnMob.onclick = disableDarkMode;
});