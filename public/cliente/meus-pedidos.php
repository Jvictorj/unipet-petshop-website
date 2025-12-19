<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes
require_once '../app/includes/functions.php';

// Segurança: Apenas logados
ensureUser();

$pageTitle = "Meus Pedidos - Área do Cliente";

// CSS Específico desta página
// Certifique-se de mover seus CSS antigos para assets/css/areacliente/
$pageCss = [
    '../assets/css/areas/cliente/clientestyle.css',
    '../assets/css/areas/cliente/meuspedidos.css' // Verifique se o nome do arquivo CSS está correto
];

require_once '../app/includes/header.php';

// Captura nome do usuário da sessão
$nomeUsuario = $_SESSION['user_name'] ?? 'Cliente';
?>

<main>
    <div class="contener-pai">
        
        <div class="mensagem-boas-vinda">
            <span>
                Olá, <b><?php echo htmlspecialchars($nomeUsuario); ?></b>! Acompanhe aqui seus pedidos e seus dados cadastrais.
            </span>
            <a href="index.php">
                <button style="padding: 10px; cursor: pointer;">Voltar para a loja</button>
            </a>
        </div>

        <div class="row">
            <div class="listas">
                <ul>
                    <li class="lista_func">
                        <a href="painel.php">
                            <i class="bi bi-grid-fill"></i> <span>Painel Principal</span>
                        </a>
                    </li>
                    <li class="lista_func" style="background-color: #fecf12;">
                        <a href="meus-pedidos.php" style="color: black;">
                            <i class="bi bi-bag"></i> <span>Meus pedidos</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="atualizar-senha.php">
                            <i class="bi bi-arrow-clockwise"></i> <span>Alterar senha</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="dados-pessoais.php">
                            <i class="bi bi-person"></i> <span>Dados pessoais</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="area-cliente-contato.php">
                            <i class="bi bi-envelope"></i> <span>Entre em contato</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="big-box">
                
                <div class="busca">
                    <form action="" method="GET" style="display: flex; gap: 10px;">
                        <input type="text" name="busca" class="inputbuscarmp" placeholder="Buscar pedido por n°"/>
                        <button type="submit">BUSCAR</button>
                    </form>
                </div>
                <br/>

                <div class="barra-de-pedidos">
                    <div class="informativo">
                        <div class="pedido">
                            <samp>Pedido</samp>
                        </div>
                        <div class="Valor">
                            <samp>Valor</samp>
                        </div>
                        <div class="Status">
                            <samp>Status</samp>
                        </div>
                    </div>

                    <br/>

                    <div class="respota-pedido">
                        <span>Nenhum pedido encontrado.</span>
                    </div>
                    
                    </div>
            </div>
        </div>
    </div>
</main>

<?php
// Inclusão do Rodapé
require_once '../app/includes/footer.php';
?>