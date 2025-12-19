<?php
// Regra 2: Iniciar sessão
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/error.php, então sobe um nível para a raiz
$path = '../'; 

// Regra 1: Includes com caminho relativo correto usando $path
require_once $path . 'app/includes/functions.php';

// Captura a mensagem de erro da URL (se existir)
$mensagemErro = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'Ocorreu um erro inesperado no sistema.';

// Configuração da Página
$pageTitle = "Unipet - Erro";

// CSS Específico usando $path
$pageCss = [$path . 'assets/css/error.css'];

// Inclusão do Cabeçalho
require_once $path . 'app/includes/header.php';
?>

<main>
    <div class="containerbody">
        <div class="title">
            <h1>Ops!</h1>
        </div>
        
        <div class="descriptiontitle">
            <p style="color: rgb(255, 132, 0);">algo deu errado :(</p>
            
            <p style="margin-top: 15px; font-weight: bold; color: #555;">
                <?php echo $mensagemErro; ?>
            </p>
            
            <p>Por favor, tente novamente ou entre em contato com o suporte.</p>
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