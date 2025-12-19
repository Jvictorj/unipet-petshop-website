<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

// Configuração da Página
$pageTitle = "Unipet - Doação e Adoção";

// CSS Específico desta página
// Nota: Evite acentos em nomes de arquivos (doacao.css -> doacao.css), mas mantive conforme seu original
$pageCss = ['../assets/css/doacao.css'];

// Inclusão do Cabeçalho
require_once '../app/includes/header.php';
?>

<section class="banner">
    <div class="banner-content">
        <div class="banner-box">
            <img class="img-desktop" src="../assets/img/banneracategoria/BANNERDOAÇÃO.png" alt="Banner Doação">
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="containerheaddescription">
            <div class="contentimg">
                <img src="../assets/img/doaçoes/UNIPETEEADOTEPETZ.png" alt="Unipet e AdotePetz">
            </div>
            <div class="description">
                <h1>Bem-vindo à plataforma de doações do projeto Unipet, em parceria com a respeitada empresa AdotePetz! </h1>
                <h1>Juntos estamos comprometidos em proporcionar uma <b style="color: #ff5900;">vida melhor</b> para animais <b style="color: #ff5900;">abandonados</b> e <b style="color: #ff5900;">desemparados</b>.</h1>
                <div class="btncomprar">
                    <button class="comprar">
                        <a class="abutton" href="https://www.adotepetz.com.br/" target="_blank">Ir à AdotePetz <i class="bi bi-arrow-right"></i></a> 
                    </button>
                </div>
            </div>
        </div>
        
        <div class="videodescription">
            <video class="videosrc" src="../Video/quemsomos/Vídeo onde mostra o cachorro da raça labrador utilizando o serviço banho e tosa da petz.mp4" autoplay muted loop></video>
        </div>
    </div>
</section>

<section class="container2">
    <div class="containerbox">
        <div class="title">
            <h1>Conheça a Adote Petz</h1>
            <p>A AdotePetz faz a conexão entre quem deseja adotar um pet com uma rede de mais de 130 ONGs e protetores parceiros. Funciona assim: a Petz disponibiliza espaços especialmente dedicados para a adoção no centro de suas lojas e as ONGs/protetores parceiros ficam responsáveis pelo processo e entrevista com os potenciais adotantes. Juntos somos mais fortes!
            <br><br>
            APOIE E FAÇA PARTE DA MAIOR REDE DE ADOÇÃO E BEM ESTAR DE CÃES E GATOS DO BRASIL.</p>
        </div>
    </div>
</section>

<section class="container3">
    <div class="containerbox2">
        <div class="imgbox">
            <a href="https://www.adotepetz.com.br/" target="_blank"> 
                <img src="../assets/img/doaçoes/imgunipetparceria.png" alt="Parceria Unipet"> 
            </a> 
        </div>
    </div>
</section>

<section class="container2">
    <div class="containerbox3" style="background-image: url('../assets/img/doaçoes/fundodoação.png');">
        <div class="title">
            <h1>Dúvidas sobre adoção?</h1>
            <p>Na área de Perguntas Frequentes, você encontra as respostas para as principais dúvidas sobre adoção. 
            Caso não encontre o que procura, entre em contato conosco que teremos o maior prazer em ajudar você.</p>
            <div class="boxbtnpgtfrequentes">
                <button class="btnpgtfrequentes">
                    <a class="abutton" href="https://www.adotepetz.com.br/fale-conosco/perguntas-frequentes" target="_blank">Perguntas Frequentes <i class="bi bi-arrow-right"></i></a> 
                </button>
            </div>
        </div>
    </div>
</section>

<?php
// Inclusão do Rodapé
require_once '../app/includes/footer.php';
?>