<?php
// Regra 2: Iniciar sessão
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
// Define que estamos 2 níveis abaixo da raiz (public/auth/ ou public/cliente/)
$path = '../../'; 

// Regra 1: Includes
require_once $path . 'app/config/conexao.php';
require_once $path . 'app/includes/functions.php';

// Segurança
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
} elseif (!isset($_SESSION['user_id'])) {
    header('Location: ' . $path . 'public/auth/login.php');
    exit;
}

$pageTitle = "Atualizar Senha - Unipet";

// CSS Específico (Caminho corrigido para assets/css/cliente/senha.css conforme seu tree)
$pageCss = [$path . 'assets/css/cliente/senha.css']; 

// Include do Header (que já usa a variável $path internamente)
require_once $path . 'app/includes/header.php';
?>

<main>
    <div class="senha-wrapper">
        <div class="senha-card">
            
            <div class="senha-header">
                <i class="bi bi-shield-lock"></i>
                <h2>Redefinir Senha</h2>
                <p>Escolha uma senha forte para proteger sua conta.</p>
            </div>

            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="msg-erro">
                    <?php 
                        foreach ($_SESSION['errors'] as $erro) { echo "<p><i class='bi bi-exclamation-circle'></i> $erro</p>"; }
                        unset($_SESSION['errors']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="msg-sucesso">
                     <p><i class='bi bi-check-circle'></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
                </div>
            <?php endif; ?>

            <form action="<?php echo $path; ?>app/actions/atualizar-senha.php" method="POST" class="senha-form">
                
                <div class="grupo-input">
                    <label for="nova_senha">Nova Senha</label>
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="nova_senha" id="nova_senha" placeholder="Digite a nova senha" required>
                    </div>
                </div>

                <div class="grupo-input">
                    <label for="confirma_senha">Confirme a Senha</label>
                    <div class="input-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="confirma_senha" id="confirma_senha" placeholder="Repita a nova senha" required>
                    </div>
                </div>

                <button type="submit" class="btn-salvar">Salvar Nova Senha</button>

                <div class="voltar-link">
                    <a href="../cliente/painel.php"><i class="bi bi-arrow-left"></i> Cancelar e Voltar</a>
                </div>

            </form>
        </div>
    </div>
</main>

<?php 
// Inclusão do Rodapé usando o $path
require_once $path . 'app/includes/footer.php'; 
?>