<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

// Configuração da Página
$pageTitle = "Acesso Restrito - Unipet";

// Vamos reutilizar o CSS da página de erro para centralizar a mensagem bonitinho
$pageCss = ['../assets/css/error.css'];

require_once '../app/includes/header.php';
?>

<main>
    <div class="containerbody">
        <div class="title">
            <h1>Acesso Restrito</h1>
        </div>
        
        <div class="descriptiontitle">
            <p style="font-size: 1.2rem;">
                Você precisa fazer 
                <a href="login.php" style="color: #fb3997; font-weight: bold; text-decoration: underline;">login</a> 
                para ter acesso a essa página.
            </p>
        </div>
        
        <div class="btncontato">
            <a href="login.php">
                <button class="btnconosco">Ir para Login</button>
            </a>
            <br><br>
            <a href="index.php" style="text-decoration: none; color: #333;">
                <i class="bi bi-arrow-left"></i> Voltar para o Início
            </a>
        </div>
    </div>
</main>

<?php
// Inclusão do Rodapé
require_once '../app/includes/footer.php';
?>