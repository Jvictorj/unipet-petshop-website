<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

// Configuração da Página
$pageTitle = "Quem Somos - Unipet";

// CSS Específico desta página
$pageCss = ['../assets/css/quemsomos.css'];

// Inclusão do Cabeçalho
require_once '../app/includes/header.php';
?>

<section class="banner">
    <div class="banner-content">
        <div class="banner-box">
            <img class="img-desktop" src="../assets/img/banneracategoria/BANNERQUEMSOMOS.png" alt="Banner Quem Somos">
        </div>
    </div>
</section>

<section class="containermain">
    <div class="container">
        
        <div class="containerheaddescription">
            <div class="contentimg">
                <img src="../assets/img/quemsomos/QUEM SOMOS.png" alt="Quem Somos Título">
            </div>
            <div class="description">
                <h1>Bem-vindo à <b style="color: rgb(255, 128, 0);">Unipet</b>, o seu destino definitivo para tudo relacionado aos cuidados e bem-estar dos seus animais de estimação.</h1>
                <h4>Fundada por sete universitários da renomada instituição Unisuam, a Unipet surgiu da paixão compartilhada por animais e da dedicação à comunidade pet.</h4>
                <div class="btncomprar">
                    <button class="comprar">
                        <a class="abutton" href="https://www.unisuam.edu.br/" target="_blank">Ir à Unisuam <i class="bi bi-arrow-right"></i></a> 
                    </button>
                </div>
            </div>
        </div>
        
        <div class="videodescription">
            <video class="videosrc" src="../videos/quemsomos/O Ninho tá On _ Boas-vindas aos alunos _ UNISUAM.mp4" autoplay muted loop></video>
        </div>
    </div>

    <div class="container2">
        <div class="containerheaddescription2">
            <div class="contentimg">
                <img src="../assets/img/quemsomos/NOSSA MISSÃO.png" alt="Nossa Missão">
            </div>
            <div class="contentimg2">
                <img src="../assets/img/quemsomos/gatinhoquemsomos.png" alt="Gatinho">
            </div>
        </div>
        <div class="containercard">
            <div class="containercard-conteudo">
                <h1>✔️ Na <b style="color: rgb(255, 128, 0);">Unipet,</b> nossa missão é fornecer <b style="color: rgb(255, 128, 0);">produtos</b> e <b style="color: rgb(255, 128, 0);"> serviços</b> de alta qualidade que <b style="color: rgb(255, 128, 0);">promovam</b> a saúde, felicidade e vitalidade dos seus animais de estimação.</h1>
                <h4>✔️ Nosso compromisso com a <b style="color: rgb(255, 128, 0);">excelência</b> se estende desde a seleção dos <b style="color: rgb(255, 128, 0);">melhores produtos</b> até a prestação de um atendimento personalizado e <b style="color: rgb(255, 128, 0);">atencioso</b> a cada cliente.</h4>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="containerheaddescription">
            <div class="contentimg">
                <img src="../assets/img/quemsomos/NOSSA VISAO.png" alt="Nossa Visão">
            </div>
            <div class="description">
                <h1>Nosso <b style="color: rgb(255, 128, 0);">objetivo</b> é nos tornarmos a <b style="color: rgb(255, 128, 0);">principal referência</b> no segmento pet, não apenas por oferecer produtos de <b style="color: rgb(255, 128, 0);">qualidade</b>, mas também por sermos reconhecidos pela nossa dedicação à comunidade pet e pela nossa contribuição para o <b style="color: rgb(255, 128, 0);">bem-estar animal</b></h1>
                
                <div class="btncomprar">
                    <button class="comprar">
                        <a class="abutton" href="categoria.php?nome=Todos" target="_blank">Produção UNIPET <i class="bi bi-arrow-right"></i></a> 
                    </button>
                </div>
            </div>
        </div>
        <div class="videodescription">
            <video class="videosrc" src="../videos/quemsomos/O Ninho tá On _ Volta às Aulas e boas-vindas aos calouros e veteranos _ UNISUAM.mp4" autoplay muted loop></video>
        </div>
    </div>
</section>

<section class="containermain">
    <div class="container3">
        <div class="containerheaddescription3">
            <div class="contentimg">
                <img src="../assets/img/quemsomos/O DIFRENCIAL.png" alt="O Diferencial">
            </div>
            <div class="contentimg3">
                <img src="../assets/img/quemsomos/cachorroquemsomos.png" alt="Cachorro">
            </div>
        </div>
        <div class="containercard1">
            <div class="containercard-conteudo">
                <h1> Na <b style="color: rgb(255, 128, 0);">Unipet</b>, valorizamos a expertise adquirida em nossa formação universitária na <b style="color: rgb(255, 128, 0);">Unisuam</b>. Combinando conhecimento teórico com <b style="color: rgb(255, 128, 0);">paixão</b> prática pelos animais.🐾 </h1>
                <h4> Estamos constantemente atualizados com as últimas <b style="color: rgb(255, 128, 0);">tendências</b> e <b style="color: rgb(255, 128, 0);">inovações</b> do setor pet. Além disso, nos destacamos por:</h4>
            </div>
        </div>
    </div>
</section>

<section class="containermain">
    <div class="container4">
        <div class="containercard3" style="background-image: url('../assets/img/quemsomos/1.png');"></div>
        <div class="containercard3" style="background-image: url('../assets/img/quemsomos/2.png');"></div>
        <div class="containercard3" style="background-image: url('../assets/img/quemsomos/3.png');"></div>
        <div class="containercard3" style="background-image: url('../assets/img/quemsomos/4.png');"></div>
        <div class="containercard3" style="background-image: url('../assets/img/quemsomos/5.png');"></div>
        <div class="containercard3" style="background-image: url('../assets/img/quemsomos/6.png');"></div>
    </div>
</section>

<hr>

<section class="containermain">
    <div class="containerfinal">
        <div class="containerboxfinal">
            <div class="containerboximgdescription">
                <div class="imgboxfinal">
                    <img src="../assets/img/quemsomos/finalquemsomos.jpg" alt="Final Quem Somos">
                </div>
                <div class="descripitionimg">
                    <h1>Tudo para manter a saúde do seu pet em dia</h1>
                    <p>Vacinas, consultas e exames com qualidade e carinho.</p>
                    <div class="btnsaibamais">
                        <a href="https://api.whatsapp.com/send?phone=5521971682272&text=Gostaria%20de%20mais%20informa%C3%A7%C3%B5es%20sobre%20a%20UniPet" target="_blank" class="btnsaiba">
                            <button>Saiba mais sobre a UNIPET</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Inclusão do Rodapé
require_once '../app/includes/footer.php';
?>