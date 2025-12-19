<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

// Configuração da Página
$pageTitle = "Unipet: Apaixonado por Animais";

// Definição de CSS Específico desta página (Index e Slider)
// Nota: Seu header.php precisa estar preparado para receber essa variável (veja instrução abaixo)
$pageCss = [
    '../assets/css/index.css',
    '../assets/css/sliderindex.css'
];

require_once '../app/includes/header.php';
?>

<section class="sectionmsg">
    <div class="mensagemcadastre-se">
    <a href="cadastre-se.php"><i class="bi bi-suit-heart-fill" ></i><span>Cadastre-se Agora! e faça parte da comunidade <B>UNIPET</B></span></a>
    </div>
</section>

<section class="slider">
    <div class="slider-content">
    <input type="radio" name="btn-radio" id="radio1">
    <input type="radio" name="btn-radio" id="radio2">
    <input type="radio" name="btn-radio" id="radio3">
    <input type="radio" name="btn-radio" id="radio4">

    <div class="slide-box primeiro">
        <a href="PaginaMenu/todososprodutos.php">
        <img class="img-desktop" src="../assets/img/banners/desktop/BANNER FELICIDADE DALMATA.png" alt="slide 1">
        <img class="img-mobile" src="../assets/img/banners/mobile/bannersmobile/1.png" alt="slide 1">
        </a>
    </div>

    <div class="slide-box">
        <a href="whiskas.php">
        <img class="img-desktop" src="../assets/img/banners/desktop/3.png" alt="slide 1">
        <img class="img-mobile" src="../assets/img/banners/mobile/bannersmobile/2.png" alt="slide 1">
        </a>
    </div>

    <div class="slide-box">
        <a href="PaginaMenu/cahorro.php">
        <img class="img-desktop" src="../assets/img/banners/desktop/1.png" alt="slide 1">
        <img class="img-mobile" src="../assets/img/banners/mobile/bannersmobile/3.png" alt="slide 1">
        </a>
    </div>

    <div class="slide-box">
        <a href="https://api.whatsapp.com/send?phone=5521971682272" target="_blank">
        <img class="img-desktop" src="../assets/img/banners/desktop/2.png" alt="slide 1">
        <img class="img-mobile" src="../assets/img/banners/mobile/bannersmobile/4.png" alt="slide 1">
        </a>
    </div>

    <div class="nav-auto">
        <div class="auto-btn1"></div>
        <div class="auto-btn2"></div>
        <div class="auto-btn3"></div>
        <div class="auto-btn4"></div>
    </div>

    <div class="nav-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
        <label for="radio3" class="manual-btn"></label>
        <label for="radio4" class="manual-btn"></label>
    </div>
    </div>
</section>

<main>
    <section class="secao categoria">
    <div class="container">
        <h2 class="h2 secao-titulo">
        <hr>
        <span class="span">Principais</span> Categorias
        </h2>

        <ul class="lista lista-item-categoria">
        <li class="lista-item">
            <div class="card-categoria">
            <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                <a href="PaginaMenu/cahorro.php">
                <img src="../assets/img/categorias/cachorro.png" alt="" class="img-cover">
                </a>
            </figure>
            <h3 class="h3"><a href="PaginaMenu/cahorro.php" class="card-titulo">Cachorro</a></h3>
            </div>
        </li>

        <li class="lista-item">
            <div class="card-categoria">
            <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                <a href="PaginaMenu/gato.php">
                <img src="../assets/img/categorias/gato.png" alt="" class="img-cover">
                </a>
            </figure>
            <h3 class="h3"><a href="PaginaMenu/gato.php" class="card-titulo">Gatos</a></h3>
            </div>
        </li>

        <li class="lista-item">
            <div class="card-categoria">
            <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                <a href="PaginaMenu/Aves.php">
                <img src="../assets/img/categorias/passaro.png" alt="" class="img-cover">
                </a>
            </figure>
            <h3 class="h3"><a href="PaginaMenu/Aves.php" class="card-titulo">Pássaro</a></h3>
            </div>
        </li>

        <li class="lista-item">
            <div class="card-categoria">
            <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                <a href="PaginaMenu/medicamento.php">
                <img src="../assets/img/categorias/medicamentos.png" alt="" class="img-cover">
                </a>
            </figure>
            <h3 class="h3"><a href="PaginaMenu/medicamento.php" class="card-titulo">Remedios</a></h3>
            </div>
        </li>

        <li class="lista-item">
            <div class="card-categoria">
            <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
                <a href="PaginaMenu/todososprodutos.php">
                <img src="../assets/img/categorias/todososprodutos.png" alt="" class="img-cover">
                </a>
            </figure>
            <h3 class="h3"><a href="PaginaMenu/todososprodutos.php" class="card-titulo">Todos os Produtos</a></h3>
            </div>
        </li>
        </ul>
    </div>
    </section>

    <hr>

    <section class="secao oferta">
    <div class="container">
        <h2 class="h2 secao-titulo">
        <span>Seu PET <span class="span"> Nossa Paixão</span></span>
        </h2>
        <ul class="lista-grid">
        <a href="https://api.whatsapp.com/send?phone=5521971682272" target="_blank">
            <li>
            <div class="card-oferta bg-image img-holder" style="background-image: url('../assets/img/CallToAction/CTA1.png'); --width: 540; --height: 374;">
                <p class="card-legenda"></p>
                <h3 class="h3 card-titulo"><span class="span"></span></h3>
            </div>
            </li>
        </a>

        <a href="PaginaMenu/gato.php">
            <li>
            <div class="card-oferta bg-image img-holder" style="background-image: url('../assets/img/CallToAction/CTA2.png'); --width: 540; --height: 374; ">
                <p class="card-legenda"></p>
                <h3 class="h3 card-titulo"><span class="span"></span></h3>
            </div>
            </li>
        </a>

        <a href="https://api.whatsapp.com/send?phone=5521971682272" target="_blank">
            <li>
            <div class="card-oferta bg-image img-holder" style="background-image: url('../assets/img/CallToAction/CTA3.png'); --width: 540; --height: 374; ">
                <p class="card-legenda"></p>
                <h3 class="h3 card-titulo"><span class="span"></span></h3>
            </div>
            </li>
        </a>
        </ul>
    </div>
    </section>

    <hr>

    <section class="secao produto">
    <div class="container">
        <h2 class="h2 secao-titulo"><span class="span">Mais</span> Vendidos</h2>

        <ul class="lista-grid">
        <li>
            <div class="card-produto">
            <div class="card-banner img-holder" >
                <a href="goldenformula.php"><img src="../assets/img/produtos/produto01.png" alt="" class="img-cover default"></a>
            </div>
            <div class="card-conteudo">
                <h3 class="h3"><a href="goldenformula.php" class="card-titulo">Ração Golden Special para Cães </a></h3>
                <data class="card-preco" value="97">R$97.00</data>
            </div>
            </div>
        </li>

        <li>
            <div class="card-produto">
            <div class="card-banner img-holder" >
                <a href="whiskas.php"><img src="../assets/img/produtos/produto02.png" alt="" class="img-cover default"></a>
            </div>
            <div class="card-conteudo">
                <h3 class="h3"><a href="whiskas.php" class="card-titulo">Promoção Leve 3 e Pague 2</a></h3>
                <data class="card-preco" value="149">R$149,90</data>
            </div>
            </div>
        </li>

        <li>
            <div class="card-produto">
            <div class="card-banner img-holder" >
                <a href="biotronnativo.php"><img src="../assets/img/produtos/produto03.png" alt="" class="img-cover default"></a>
            </div>
            <div class="card-conteudo">
                <h3 class="h3"><a href="biotronnativo.php" class="card-titulo">Biotron Nativos</a></h3>
                <data class="card-preco" value="69">R$69.97</data>
            </div>
            </div>
        </li>

        <li>
            <div class="card-produto">
            <div class="card-banner img-holder" >
                <a href="simparic.php"><img src="../assets/img/produtos/produto04.png" alt="" class="img-cover default"></a>
            </div>
            <div class="card-conteudo">
                <h3 class="h3"><a href="simparic.php" class="card-titulo">Simparic</a></h3>
                <data class="card-preco" value="49">R$1.00</data>
            </div>
            </div>
        </li>
        </ul>
    </div>
    </section>

    <hr>

    <section class="secao servico" >
    <div class="container">
        <div class="boximgtudoqueseupetprecisa">
        <a href="PaginaMenu/todososprodutos.php">
            <img src="../assets/img/sectionindex/querocomprarunipet.png" class="imgtudoqueseupetprecisa" alt="" class="img">
        </a>
        </div>

        <img src="../assets/img/service-image.png" class="img" alt="">

        <h2 class="h2 secao-titulo">
        <span class="span">Tudo Que Seu Pet Precisa,</span> Quando Ele Precisa.
        </h2>

        <ul class="lista-grid">
        <li>
            <div class="card-servico">
            <figure class="card-icon"><img src="../assets/img/service-icon-1.png" alt=""></figure>
            <h3 class="h3 card-titulo">Temos Delivery!</h3>
            <p class="card-texto">Após a confirmação do pagamento ja iniciaremos o processo para enviar o produto do seu amigão!</p>
            </div>
        </li>
        <li>
            <div class="card-servico">
            <figure class="card-icon"><img src="../assets/img/service-icon-2.png" alt=""></figure>
            <h3 class="h3 card-titulo">Garantia ou Reembolso</h3>
            <p class="card-texto">A Unipet oferece 30 Dias de Garantia ou Reembolso caso o produto apresentar problema.</p>
            </div>
        </li>
        <li>
            <div class="card-servico">
            <figure class="card-icon"><img src="../assets/img/service-icon-3.png" alt=""></figure>
            <h3 class="h3 card-titulo">Compra Segura</h3>
            <p class="card-texto">Pagamento totalmente seguro e confiavel.</p>
            </div>
        </li>
        <li>
            <div class="card-servico">
            <figure class="card-icon"><img src="../assets/img/service-icon-4.png" alt=""></figure>
            <h3 class="h3 card-titulo">Suporte 24/7</h3>
            <p class="card-texto">Nossa equipe estará sempre aqui para ajudar você.</p>
            </div>
        </li>
        </ul>
    </div>
    </section>

    <hr>

    <section>
    <div class="container">
        <div class="imgsection">
        <img src="../assets/img/sectionindex/entreemcontatounipet.png" alt="" class="w-100">
        </div>
        <h2 class="h2 secao-titulo">
        <span class="span">Alguma Dúvida?<br></span> Fale com nossa Equipe.
        </h2>
        <div class="btncontato">
        <button class="btnconosco">Fale Conosco</button>
        </div>
        <div class="gato-content">
        <img src="" alt="" class="img">
        <h2 class="h2 secao-titulo"></h2>
        <p class="secao-texto"><a href="" id="invisivel"></a></p>
        </div>
    </div>
    </section>

    <hr>

    <section class="secao marca">
    <div class="container">
        <h2 class="h2 secao-titulo"><span class="span">Marcas</span> Populares</h2>
        <ul class="lista">
        <li class="lista-item">
            <div class="card-marca img-holder" style="--width: 150; --height: 150;">
            <img src="../assets/img/marcas/brand-1.jpg" alt="" class="img-cover">
            </div>
        </li>
        <li class="lista-item">
            <div class="card-marca img-holder" style="--width: 150; --height: 150;">
            <img src="../assets/img/marcas/brand-2.jpg" alt="" class="img-cover">
            </div>
        </li>
        <li class="lista-item">
            <div class="card-marca img-holder" style="--width: 150; --height: 150;">
            <img src="../assets/img/marcas/brand-3.jpg" alt="" class="img-cover">
            </div>
        </li>
        <li class="lista-item">
            <div class="card-marca img-holder" style="--width: 150; --height: 150;">
            <img src="../assets/img/marcas/brand-4.jpg" alt="" class="img-cover">
            </div>
        </li>
        <li class="lista-item">
            <div class="card-marca img-holder" style="--width: 150; --height: 150;">
            <img src="../assets/img/marcas/brand-5.jpg" alt="" class="img-cover">
            </div>
        </li>
        </ul>
    </div>
    </section>
</main>

<script src="../assets/js/slide.js" defer></script>

<?php
require_once '../app/includes/footer.php';
?>