<?php
// Regra 2: Iniciar sessão
session_start();

// --- 1. CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/admin/, sobe 2 níveis para a raiz
$path = '../../'; 

// Regra 1: Includes (Conexão e Funções) usando $path
require_once $path . 'app/config/conexao.php';
require_once $path . 'app/includes/functions.php';

// Segurança: Verifica se está logado E se é ADMIN ou MASTER
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
}

if (!isset($_SESSION['user_nivel_acesso']) || !in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
    // Se não for admin/master, manda para o painel de cliente
    header('Location: ../cliente/painel.php');
    exit;
}

$pageTitle = "Dados do Funcionário - Unipet";

// CSS Específico usando $path
$pageCss = [
    $path . 'assets/css/cliente/clientestyle.css',
    $path . 'assets/css/cliente/contato.css'
];

// --- LÓGICA PARA BUSCAR DADOS DO USUÁRIO LOGADO ---
try {
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$dados) {
        die("Erro ao carregar dados: Usuário não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao carregar dados do banco.");
}

require_once $path . 'app/includes/header.php';

$nomeFuncionario = $dados['nome_completo'];
?>

<main>
    <div class="contener-pai">
        
        <div class="mensagem-boas-vinda" style="border-left: 5px solid #fecf12;">
            <span>
                Olá, <b><?php echo htmlspecialchars($nomeFuncionario); ?></b> (<?php echo ucfirst($_SESSION['user_nivel_acesso']); ?>).
            </span>
            <a href="painel.php">
                <button style="padding: 10px; cursor: pointer;">Voltar ao Painel</button>
            </a>
        </div>

        <div class="row" style="display: flex; gap: 20px;">
            <div class="listas" style="flex: 1; min-width: 250px;">
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
                    <li class="lista_func">
                        <a href="admin-contato.php">
                            <i class="bi bi-headset"></i> <span>Suporte ao Cliente</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="../auth/atualizar-senha.php">
                            <i class="bi bi-key"></i> <span>Alterar Minha Senha</span>
                        </a>
                    </li>
                    <li class="lista_func" style="background-color: #fecf12;">
                        <a href="admin-dados.php" style="color: black;">
                            <i class="bi bi-person-badge"></i> <span>Meus Dados</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dp-main" style="flex: 3; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <div class="dp-top">
                    <h3>Dados do Colaborador</h3>
                    <hr>
                </div>
                
                <form>
                    <div class="input-dp" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">CPF</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['cpf']); ?>" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; background-color: #f0f0f0; border-radius: 4px;">
                    </div>
                    
                    <div class="input-dp" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nome Completo</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['nome_completo']); ?>" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; background-color: #f0f0f0; border-radius: 4px;">
                    </div>
                    
                    <div class="input-dp" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Data de Nascimento</label>
                        <input type="text" value="<?php echo date('d/m/Y', strtotime($dados['data_nascimento'])); ?>" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; background-color: #f0f0f0; border-radius: 4px;">
                    </div>
                    
                    <div class="input-dp" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Telefone</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['telefone_celular']); ?>" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; background-color: #f0f0f0; border-radius: 4px;">
                    </div>
                    
                    <div class="input-dp" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">E-mail Corporativo/Pessoal</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['email']); ?>" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; background-color: #f0f0f0; border-radius: 4px;">
                    </div>
                    
                    <div class="input-dp" style="margin-top: 20px; text-align: right;">
                        <button type="button" onclick="alert('Por favor, abra um chamado com o RH ou TI para alterar dados contratuais.')" style="padding: 10px 20px; background-color: #fb3997; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            Solicitar Alteração
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
// Inclusão do Rodapé
require_once $path . 'app/includes/footer.php';
?>