<?php
// 1. Iniciar sessão
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
// Define que estamos 2 níveis abaixo da raiz (public/cliente/)
// Isso vai gerar: ../../
$path = '../../'; 

// 2. Includes (Usando a variável $path)
require_once $path . 'app/includes/functions.php';
require_once $path . 'app/config/conexao.php';

// 3. Segurança: Apenas logados
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . $path . 'public/auth/login.php');
    exit;
}

// 4. Variáveis de Sessão
$user_nivel = $_SESSION['user_nivel_acesso'] ?? 'cliente';
$user_name = $_SESSION['nome_completo'] ?? 'Usuário';

$pageTitle = "Painel de Controle | Unipet";

// 5. CSS Específico desta página
// Caminho confirmado pelo seu 'tree': assets/css/cliente/clientestyle.css
$pageCss = [$path . 'assets/css/cliente/clientestyle.css']; 

// 6. Carrega o Header
require_once $path . 'app/includes/header.php';
?>

<main>
    <div class="contener-pai">
        
        <div class="mensagem-boas-vinda" style="flex-direction: column; align-items: flex-start; gap: 10px;">
            <h1 style="font-size: 2.2rem; color: #333;">Painel de Controle</h1>
            <span>
                Bem-vindo(a), <b><?php echo htmlspecialchars($user_name); ?></b>! 
                <span style="background: #eee; padding: 2px 8px; border-radius: 4px; font-size: 0.9rem;">
                    <?php echo ucfirst($user_nivel); ?>
                </span>
            </span>
        </div>

        <div class="row">
            <div class="listas">
                <ul>
                    <li class="lista_func" style="background-color: #fecf12;">
                        <a href="painel.php" style="color: black;">
                            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                        </a>
                    </li>

                    <?php if ($user_nivel === 'admin' || $user_nivel === 'master'): ?>
                        <li class="lista_func"><a href="../admin/admin-pedidos.php"><i class="bi bi-box-seam"></i> <span>Pedidos Clientes</span></a></li>
                        <li class="lista_func"><a href="../admin/admin-produtos.php"><i class="bi bi-plus-circle"></i> <span>Gerenciar Produtos</span></a></li>
                        <li class="lista_func"><a href="../admin/admin-contato.php"><i class="bi bi-headset"></i> <span>Suporte</span></a></li>
                        <li class="lista_func"><a href="../admin/admin-dados.php"><i class="bi bi-person-badge"></i> <span>Meus Dados</span></a></li>
                        
                        <?php if ($user_nivel === 'master'): ?>
                            <li class="lista_func" style="border-top: 2px solid #333;">
                                <a href="../admin/master-usuarios.php" style="color: #d63384;"><i class="bi bi-shield-lock"></i> <span>Área Master</span></a>
                            </li>
                        <?php endif; ?>

                    <?php else: ?>
                        <li class="lista_func"><a href="meus-pedidos.php"><i class="bi bi-bag"></i> <span>Meus Pedidos</span></a></li>
                        <li class="lista_func"><a href="dados-pessoais.php"><i class="bi bi-person"></i> <span>Dados Pessoais</span></a></li>
                        <li class="lista_func"><a href="area-cliente-contato.php"><i class="bi bi-envelope"></i> <span>Fale Conosco</span></a></li>
                    <?php endif; ?>

                    <li class="lista_func"><a href="../auth/atualizar-senha.php"><i class="bi bi-key"></i> <span>Alterar Senha</span></a></li>
                    
                    <li class="lista_func">
                        <a href="<?php echo $path; ?>app/actions/auth/logout.php" style="color: red;">
                            <i class="bi bi-box-arrow-right"></i> <span>Sair</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="big-box" style="background: transparent; box-shadow: none; padding: 0;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <?php if ($user_nivel === 'admin' || $user_nivel === 'master'): ?>
                        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center;">
                            <i class="bi bi-cart4" style="font-size: 3rem; color: #fb3997;"></i>
                            <h3>Vendas Hoje</h3>
                            <p style="font-size: 2rem; font-weight: bold;">0</p>
                        </div>
                    <?php else: ?>
                        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center;">
                            <i class="bi bi-bag-check" style="font-size: 3rem; color: #28a745;"></i>
                            <h3>Status</h3>
                            <p>Conta Ativa</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once $path . 'app/includes/footer.php'; ?>