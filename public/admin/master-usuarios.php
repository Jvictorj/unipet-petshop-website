<?php
// Regra 2: Iniciar sessão
session_start();

// --- 1. CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/admin/, então sobe dois níveis para a raiz
$path = '../../'; 

// Regra 1: Includes (Conexão e Funções) usando $path
require_once $path . 'app/config/conexao.php';
require_once $path . 'app/includes/functions.php';

// Segurança
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
}

// Segurança Máxima: Apenas nível Master
if ($_SESSION['user_nivel_acesso'] !== 'master') {
    header('Location: ../cliente/painel.php'); 
    exit;
}

// Lógica de alteração de cargo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['novo_cargo'])) {
    $uid = (int)$_POST['usuario_id'];
    $cargo = $_POST['novo_cargo'];
    
    if($uid === $_SESSION['user_id'] && $cargo !== 'master') {
        echo "<script>alert('Você não pode rebaixar seu próprio cargo!');</script>";
    } else {
        $stmt = $pdo->prepare("UPDATE usuario SET nivel_acesso = :cargo WHERE id = :id");
        $stmt->execute(['cargo' => $cargo, 'id' => $uid]);
        
        if (function_exists('registrarLog')) {
            registrarLog($pdo, $_SESSION['user_id'], 'ALTERAR_CARGO', "Alterou usuário ID $uid para $cargo");
        }
        echo "<script>alert('Cargo atualizado com sucesso!'); location.href='master-usuarios.php';</script>";
    }
}

// Busca usuários
$usuarios = $pdo->query("SELECT id, nome_completo, email, nivel_acesso FROM usuario ORDER BY id DESC")->fetchAll();

$pageTitle = "Gestão Master - Usuários";

// CSS Específico (Caminho corrigido para assets/css/admin/)
$pageCss = [$path . 'assets/css/admin/master-style.css']; 

// Include do Cabeçalho
require_once $path . 'app/includes/header.php';
?>

<main class="master-main">
    <div class="master-container">
        
        <div class="master-header">
            <h1 class="master-title"><i class="bi bi-shield-lock-fill"></i> Gestão de Acessos</h1>
            <a href="relatorios.php" class="btn-master">
                <i class="bi bi-file-earmark-text"></i> Ver Logs do Sistema
            </a>
        </div>

        <div class="table-responsive">
            <table class="master-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Cargo Atual</th>
                        <th>Alterar Cargo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td>#<?= $u['id'] ?></td>
                        <td style="font-weight: bold;"><?= htmlspecialchars($u['nome_completo']) ?></td>
                        <td style="color: #666;"><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="badge badge-<?= $u['nivel_acesso'] ?>">
                                <?= strtoupper($u['nivel_acesso']) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" class="form-inline">
                                <input type="hidden" name="usuario_id" value="<?= $u['id'] ?>">
                                <select name="novo_cargo" class="select-cargo">
                                    <option value="cliente" <?= $u['nivel_acesso'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                                    <option value="admin" <?= $u['nivel_acesso'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="master" <?= $u['nivel_acesso'] == 'master' ? 'selected' : '' ?>>Master</option>
                                </select>
                                <button type="submit" class="btn-save">Salvar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php 
// Inclusão do Rodapé usando $path
require_once $path . 'app/includes/footer.php'; 
?>