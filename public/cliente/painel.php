<?php
// 1. Iniciar sessão
session_start();

// 2. Includes
require_once '../app/includes/functions.php';

// 3. Segurança: Apenas logados
ensureAuthenticated();

// 4. Variáveis de Sessão
$user_nivel = $_SESSION['user_nivel_acesso'] ?? 'cliente';
$user_name = $_SESSION['user_name'] ?? 'Usuário';

$pageTitle = "Painel de Controle | Unipet";
$pageCss = ['../assets/css/areas/cliente/clientestyle.css']; 

require_once '../app/includes/header.php';
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
                        <li class="lista_func">
                            <a href="admin-pedidos.php">
                                <i class="bi bi-box-seam"></i> <span>Pedidos Clientes</span>
                            </a>
                        </li>
                        <li class="lista_func">
                            <a href="admin-produtos.php">
                                <i class="bi bi-plus-circle"></i> <span>Gerenciar Produtos</span>
                            </a>
                        </li>
                        <li class="lista_func">
                            <a href="admin-contato.php">
                                <i class="bi bi-headset"></i> <span>Suporte</span>
                            </a>
                        </li>
                        <li class="lista_func">
                            <a href="admin-dados.php">
                                <i class="bi bi-person-badge"></i> <span>Meus Dados</span>
                            </a>
                        </li>
                        
                        <?php if ($user_nivel === 'master'): ?>
                            <li class="lista_func" style="border-top: 2px solid #333;">
                                <a href="master-usuarios.php" style="color: #d63384;">
                                    <i class="bi bi-shield-lock"></i> <span>Área Master</span>
                                </a>
                            </li>
                        <?php endif; ?>

                    <?php else: ?>
                        <li class="lista_func">
                            <a href="meus-pedidos.php">
                                <i class="bi bi-bag"></i> <span>Meus Pedidos</span>
                            </a>
                        </li>
                        <li class="lista_func">
                            <a href="dados-pessoais.php">
                                <i class="bi bi-person"></i> <span>Dados Pessoais</span>
                            </a>
                        </li>
                        <li class="lista_func">
                            <a href="area-cliente-contato.php">
                                <i class="bi bi-envelope"></i> <span>Fale Conosco</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="lista_func">
                        <a href="atualizar-senha.php">
                            <i class="bi bi-key"></i> <span>Alterar Senha</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="../app/includes/logout.php" style="color: red;">
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
                            <small>Em desenvolvimento</small>
                        </div>
                        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center;">
                            <i class="bi bi-box" style="font-size: 3rem; color: #fecf12;"></i>
                            <h3>Produtos</h3>
                            <a href="admin-produtos.php" style="color: blue;">Gerenciar</a>
                        </div>
                    <?php else: ?>
                        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center;">
                            <i class="bi bi-bag-check" style="font-size: 3rem; color: #28a745;"></i>
                            <h3>Último Pedido</h3>
                            <p>Nenhum pedido recente.</p>
                            <a href="index.php" style="color: blue; text-decoration: underline;">Ir às compras</a>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</main>

<?php require_once '../app/includes/footer.php'; ?>