<?php
// Garante que $path exista (caso o footer seja chamado isoladamente em algum teste)
if (!isset($path)) {
    $path = '../';
}
?>

<footer class="rodape" style="background-image: url('<?php echo $path; ?>assets/img/footer-bg.jpg')">
    <div class="rodape-topo secao">
        <div class="container">
            <div class="rodape-marca">
                <a href="#" class="logo">Unipet</a>
                <p class="rodape-texto">
                    Se você tiver alguma dúvida, entre em contato conosco em <a href="mailto:unisuampet@gmail.com" class="link">unisuampet@gmail.com</a>
                </p>
                <ul class="lista-contato">
                    <li class="item-contato">
                        <i class="icon-contato bi bi-geo-alt"></i>
                        <address class="address">A Definir</address>
                    </li>
                    <li class="item-contato">
                        <i class="icon-contato bi bi-telephone"></i>
                        <a href="tel:+5521971682272" class="contact-link">(55+) 21 97168-2272</a>
                    </li>
                </ul>
                <ul class="lista-social">
                    <li>
                        <a href="https://www.instagram.com/unipetrj/" class="social-link" target="_blank">
                            <li class="social-icon" style="--cor-icon: #FB3997; --cor-icon2: #FECF12;">
                                <span class="icon"><i class="bi bi-instagram"></i></span>
                                <span class="icon-texto">Instagram</span>
                            </li>
                        </a>
                    </li>
                    <li>
                        <a href="https://api.whatsapp.com/send?phone=5521971682272" class="social-link" target="_blank">
                            <li class="social-icon" style="--cor-icon: #13c552; --cor-icon2: #26a31a;">
                                <span class="icon"><i class="bi bi-whatsapp"></i></span>
                                <span class="icon-texto">Whatsapp</span>
                            </li>
                        </a>
                    </li>
                </ul>
            </div>

            <ul class="rodape-lista">
                <li><p class="rodape-lista-titulo">Corporativo</p></li>
                <li><a href="#" class="rodape-link">Carreiras</a></li>
                <li><a href="#" class="rodape-link">Quem Somos</a></li>
                <li><a href="#" class="rodape-link">Fale Conosco</a></li>
            </ul>

            <ul class="rodape-lista">
                <li><p class="rodape-lista-titulo">Informação</p></li>
                <li><a href="#" class="rodape-link">Loja Online</a></li>
                <li><a href="#" class="rodape-link">Politica de Privacidade</a></li>
            </ul>

            <ul class="rodape-lista">
                <li><p class="rodape-lista-titulo">Serviços</p></li>
                <li><a href="#" class="rodape-link">Tosa</a></li>
                <li><a href="#" class="rodape-link">Adestramento de Cães</a></li>
            </ul>
        </div>
    </div>

    <div class="rodape-inferior">
        <div class="container">
            <p class="copyright">&copy; 2024 Feito por <a href="#" class="copyright-link">João.</a></p>
            <img src="<?php echo $path; ?>assets/img/payment.png" alt="Formas de Pagamento" class="img">
        </div>
    </div>
</footer>

<script src="<?php echo $path; ?>assets/js/produto.js"></script>
<a href="https://api.whatsapp.com/send?phone=5521971682272" target="_blank">
    <img src="https://host2b.net/download/imagem/whatsapp-icon.png" style="height:60px; position:fixed; bottom:25px; left:25px; z-index:99999;" data-selector="img">
</a>

</body>
</html>