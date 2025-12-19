<?php
// Regra 2: Iniciar sessão
session_start();

// --- 1. CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/admin/, sobe 2 níveis para a raiz do projeto
$path = '../../'; 

// Regra 1: Includes (Conexão e Funções) usando a variável $path
require_once $path . 'app/config/conexao.php'; // Caminho corrigido conforme sua árvore
require_once $path . 'app/includes/functions.php';

// Segurança: Verifica se está logado E se é ADMIN ou MASTER
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
}

if (!isset($_SESSION['user_nivel_acesso']) || !in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
    // Se não for admin/master, redireciona para o painel de cliente
    header('Location: ../cliente/painel.php');
    exit;
}

$pageTitle = "Suporte ao Cliente - Admin Unipet";

// CSS Específico usando $path para localizar os assets corretamente
$pageCss = [
    $path . 'assets/css/cliente/clientestyle.css',
    $path . 'assets/css/cliente/contato.css'
];

require_once $path . 'app/includes/header.php';

$nomeAdmin = $_SESSION['user_name'] ?? 'Administrador';
?>

<main>
    <div class="contener-pai">
        
        <div class="mensagem-boas-vinda" style="border-left: 5px solid #fecf12;">
            <span>
                Olá, <b><?php echo htmlspecialchars($nomeAdmin); ?></b>! Central de Suporte ao Cliente.
            </span>
            <a href="painel.php">
                <button style="padding: 10px; cursor: pointer;">Voltar ao Painel</button>
            </a>
        </div>

        <div class="row">
            <div class="listas">
                <ul>
                    <li class="lista_func">
                        <a href="painel.php">
                            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="admin-pedidos.php">
                            <i class="bi bi-box-seam"></i> <span>Pedidos dos Clientes</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="admin-produtos.php">
                            <i class="bi bi-plus-circle"></i> <span>Gerenciar Produtos</span>
                        </a>
                    </li>
                    <li class="lista_func" style="background-color: #fecf12;">
                        <a href="admin-contato.php" style="color: black;">
                            <i class="bi bi-headset"></i> <span>Suporte ao Cliente</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="../auth/atualizar-senha.php">
                            <i class="bi bi-key"></i> <span>Alterar Minha Senha</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="admin-dados.php">
                            <i class="bi bi-person-badge"></i> <span>Meus Dados</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="big-box" style="padding: 20px; background: white; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); flex: 1;">
                
                <h2 style="color: #fb3997; margin-bottom: 20px;">Mensagens Recebidas</h2>

                <div class="barra-de-pedidos">
                    <div class="informativo" style="display: grid; grid-template-columns: 1fr 2fr 3fr 1fr; text-align: center; font-weight: bold; background: #eee; padding: 10px; border-radius: 4px;">
                        <div>Data</div>
                        <div>Cliente</div>
                        <div>Mensagem</div>
                        <div>Ação</div>
                    </div>

                    <br/>

                    <div class="respota-pedido" style="text-align: center; padding: 40px; color: #888;">
                        <i class="bi bi-chat-dots" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        <span>Nenhuma mensagem nova de suporte.</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Inclusão do Rodapé usando $path
require_once $path . 'app/includes/footer.php';
?>