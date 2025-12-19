<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes
require_once '../app/includes/conexao.php';
require_once '../app/includes/functions.php';

// Segurança: Verifica se está logado E se é ADMIN
ensureAuthenticated();

if (!isset($_SESSION['user_nivel_acesso']) || $_SESSION['user_nivel_acesso'] !== 'admin') {
    // Se for cliente tentando entrar aqui, manda pro painel dele
    header('Location: painel.php');
    exit;
}

$pageTitle = "Dados do Funcionário - Unipet";

// CSS Específico (assumindo que você tem uma pasta para estilo de funcionario ou reusa o do cliente)
$pageCss = [
    '../assets/css/areas/cliente/clientestyle.css',
    '../assets/css/areas/cliente/contato.css'
];

// --- LÓGICA PARA BUSCAR DADOS DO ADMIN ---
try {
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar dados.");
}

require_once '../app/includes/header.php';

$nomeFuncionario = $dados['nome_completo'];
?>

<main>
    <div class="contener-pai">
        
        <div class="mensagem-boas-vinda" style="border-left: 5px solid #fecf12;">
            <span>
                Olá, <b><?php echo htmlspecialchars($nomeFuncionario); ?></b> (Administrador).
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
                    <li class="lista_func">
                        <a href="admin-contato.php">
                            <i class="bi bi-headset"></i> <span>Suporte ao Cliente</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="atualizar-senha.php">
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

            <div class="dp-main">
                <div class="dp-top">
                    <h3>Dados do Colaborador</h3>
                    <hr>
                </div>
                
                <form>
                    <div class="input-dp">
                        <label for="cpf">CPF</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['cpf']); ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                    
                    <div class="input-dp">
                        <label for="nome">Nome Completo</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['nome_completo']); ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                    
                    <div class="input-dp">
                        <label for="nascimento">Data de Nascimento</label>
                        <input type="text" value="<?php echo date('d/m/Y', strtotime($dados['data_nascimento'])); ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                    
                    <div class="input-dp">
                        <label for="telefone">Telefone</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['telefone_celular']); ?>">
                    </div>
                    
                    <div class="input-dp">
                        <label for="email">E-mail Corporativo/Pessoal</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['email']); ?>">
                    </div>
                    
                    <div class="input-dp" style="margin-top: 20px; text-align: right;">
                        <button type="button" onclick="alert('Entre em contato com o TI para alterar seus dados.')" style="padding: 10px 20px; background-color: #fb3997; color: white; border: none; border-radius: 5px; cursor: pointer;">
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
require_once '../app/includes/footer.php';
?>