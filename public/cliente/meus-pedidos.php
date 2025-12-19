<?php
// 1. Iniciar sessão
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
// Define que estamos 2 níveis abaixo da raiz (public/cliente/)
$path = '../../'; 

// 2. Includes (Conexão e Funções)
require_once $path . 'app/config/conexao.php'; // Necessário para usar $pdo
require_once $path . 'app/includes/functions.php';

// Segurança: Apenas logados
// Se a função ensureUser não existir, use if(!isset($_SESSION['user_id']))...
if (function_exists('ensureUser')) {
    ensureUser();
} elseif (!isset($_SESSION['user_id'])) {
    header('Location: ' . $path . 'public/auth/login.php');
    exit;
}

$pageTitle = "Meus Pedidos - Área do Cliente";

// CSS Específico (Caminhos corrigidos baseados no seu Tree)
$pageCss = [
    $path . 'assets/css/cliente/clientestyle.css',
    $path . 'assets/css/cliente/meuspedidos.css'
];

require_once $path . 'app/includes/header.php';

// Captura nome do usuário da sessão
$nomeUsuario = $_SESSION['user_name'] ?? 'Cliente';

// --- LÓGICA PARA BUSCAR PEDIDOS (Exemplo Básico) ---
$pedidos = [];
// Descomente e ajuste quando tiver a tabela de pedidos
/*
try {
    $sql = "SELECT * FROM pedidos WHERE usuario_id = :uid ORDER BY data_pedido DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['uid' => $_SESSION['user_id']]);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Erro silencioso ou log
}
*/
?>

<main>
    <div class="contener-pai">
        
        <div class="mensagem-boas-vinda">
            <span>
                Olá, <b><?php echo htmlspecialchars($nomeUsuario); ?></b>! Acompanhe aqui seus pedidos e seus dados cadastrais.
            </span>
            <a href="../index.php">
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
                        <a href="../auth/atualizar-senha.php">
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
                        <?php if (count($pedidos) > 0): ?>
                            <?php foreach($pedidos as $pedido): ?>
                                <div class="item-pedido" style="display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee;">
                                    <span>#<?php echo $pedido['id']; ?></span>
                                    <span>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span>
                                    <span><?php echo $pedido['status']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span>Nenhum pedido encontrado.</span>
                        <?php endif; ?>
                    </div>
                    
                    </div>
            </div>
        </div>
    </div>
</main>

<?php
// Inclusão do Rodapé
require_once $path . 'app/includes/footer.php';
?>