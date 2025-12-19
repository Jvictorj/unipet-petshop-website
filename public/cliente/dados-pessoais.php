<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes (Conexão e Funções)
require_once '../../app/config/conexao.php'; // Necessário para usar $pdo
require_once '../../app/includes/functions.php';

// Segurança: Apenas logados
ensureUser();

$pageTitle = "Dados Pessoais - Área do Cliente";

// CSS Específico
$pageCss = [
    '../../assets/css/cliente/clientestyle.css',
    '../../assets/css/cliente/dadospessoais.css'
];


// --- LÓGICA PARA BUSCAR DADOS DO USUÁRIO ---
try {
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se não achar o usuário (erro raro), força logout
    if (!$dados) {
        header('Location: ../app/includes/logout.php');
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao carregar dados.");
}

require_once '../../app/includes/header.php';

// Captura nome para a saudação
$nomeUsuario = $dados['nome_completo'];
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
                    <li class="lista_func">
                        <a href="meus-pedidos.php">
                            <i class="bi bi-bag"></i> <span>Meus pedidos</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="atualizar-senha.php">
                            <i class="bi bi-arrow-clockwise"></i> <span>Alterar senha</span>
                        </a>
                    </li>
                    <li class="lista_func" style="background-color: #fecf12;">
                        <a href="dados-pessoais.php" style="color: black;">
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

            <div class="dp-main">
                <div class="dp-top">
                    <h3>Meus Dados Cadastrais</h3>
                    <hr>
                </div>
                
                <form>
                    <div class="input-dp">
                        <label for="cpf">CPF</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['cpf']); ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                    
                    <div class="input-dp">
                        <label for="nome">Nome completo</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['nome_completo']); ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                    
                    <div class="input-dp">
                        <label for="nascimento">Data de Nascimento</label>
                        <input type="text" value="<?php echo date('d/m/Y', strtotime($dados['data_nascimento'])); ?>" readonly style="background-color: #f0f0f0;">
                    </div>
                    
                    <div class="input-dp">
                        <label for="telefone">Telefone Celular</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['telefone_celular']); ?>">
                    </div>
                    
                    <div class="input-dp">
                        <label for="email">E-mail</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['email']); ?>">
                    </div>

                    <div class="input-dp">
                        <label for="endereco">Endereço Completo</label>
                        <input type="text" value="<?php echo htmlspecialchars($dados['endereco_completo']); ?>">
                    </div>

                    <div class="input-dp" style="margin-top: 20px; text-align: right;">
                        <button type="button" onclick="alert('Funcionalidade de edição em breve!')" style="padding: 10px 20px; background-color: #fb3997; color: white; border: none; border-radius: 5px; cursor: pointer;">
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
require_once '../../app/includes/footer.php';
?>