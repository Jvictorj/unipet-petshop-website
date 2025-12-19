<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

// Configuração da Página
$pageTitle = "Unipet - Página não encontrada";

// Esta página usa um CSS específico além dos padrões.
// Passamos ele para o header.php carregar.
$pageCss = ['../assets/css/error.css'];

require_once '../app/includes/header.php';
?>

<main>
    <div class="containerbody">
        <div class="title">
            <h1>Ops! erro 404</h1>
        </div>
        
        <div class="descriptiontitle">
            <p style="color: rgb(255, 132, 0);">algo deu errado :( </p>
            <p>Por favor entre em contato conosco ou volte a tela inicial.</p>
        </div>
        
        <div class="btncontato">
            <a href="cliente/area-cliente-contato.php">
                <button class="btnconosco">Fale Conosco</button>
            </a>
        </div>
        <a href="index.php" style="text-decoration: none; color: #2b2a2aff;">
                <i class="bi bi-arrow-left"></i> Voltar para o Início
        </a>
    </div>
</main>

<?php
// Inclusão do Rodapé
require_once '../app/includes/footer.php';
?>