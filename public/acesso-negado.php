<?php
// Regra 2: Iniciar sessão
session_start();

// --- 1. CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/acesso-negado.php, sobe 1 nível para a raiz
$path = '../'; 

// Regra 1: Includes com caminho relativo correto usando $path
require_once $path . 'app/includes/functions.php';

// Configuração da Página
$pageTitle = "Acesso Restrito - Unipet";

// Reutilização do CSS usando $path
$pageCss = [$path . 'assets/css/error.css'];

// Inclusão do Cabeçalho
require_once $path . 'app/includes/header.php';
?>

<main>
    <div class="containerbody">
        <div class="title">
            <h1>Acesso Restrito</h1>
        </div>
        
        <div class="descriptiontitle">
            <p style="font-size: 1.2rem;">
                Você precisa fazer 
                <a href="auth/login.php" style="color: #fb3997; font-weight: bold; text-decoration: underline;">login</a> 
                para ter acesso a essa página.
            </p>
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
// Inclusão do Rodapé usando $path
require_once $path . 'app/includes/footer.php';
?>