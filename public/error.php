<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

// Captura a mensagem de erro da URL (se existir), senão usa uma padrão
// Exemplo de uso: header("Location: error.php?msg=Senha incorreta");
$mensagemErro = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'Ocorreu um erro inesperado no sistema.';

// Configuração da Página
$pageTitle = "Unipet - Erro";

// Reutilizamos o CSS da página de erro (404) pois o layout é o mesmo
$pageCss = ['../assets/css/error.css'];

// Inclusão do Cabeçalho
require_once '../app/includes/header.php';
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
            <a href="contato.php">
                <button class="btnconosco">Fale Conosco</button>
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