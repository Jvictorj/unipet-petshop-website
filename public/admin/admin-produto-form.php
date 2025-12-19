<?php
// Regra 2: Iniciar sessão
session_start();

// --- 1. CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/admin/, sobe 2 níveis para a raiz
$path = '../../'; 

// Regra 1: Includes (Conexão e Funções) usando $path
// Note: ajustado para app/config/ conforme sua árvore anterior
require_once $path . 'app/config/conexao.php';
require_once $path . 'app/includes/functions.php';

// Segurança
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
}

// Opcional: Restringir acesso
if (!isset($_SESSION['user_nivel_acesso']) || !in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
    header('Location: ../cliente/painel.php'); 
    exit; 
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$produto = null;

// Se tem ID, busca os dados para Edição
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $produto = $stmt->fetch();
}

$pageTitle = $id ? "Editar Produto" : "Cadastrar Novo Produto";

// CSS Específico usando $path
$pageCss = [$path . 'assets/css/admin/admin-form.css'];

// Include do Cabeçalho
require_once $path . 'app/includes/header.php';
?>

<main class="admin-main">
    <div class="form-card">
        <h2 class="form-title">
            <i class="bi bi-box-seam"></i> <?php echo $pageTitle; ?>
        </h2>
        
        <form action="<?php echo $path; ?>app/actions/admin/produto_salvar.php" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="id" value="<?php echo $produto['id'] ?? ''; ?>">
            
            <div class="form-group">
                <label for="nome">Nome do Produto:</label>
                <input type="text" name="nome" id="nome" class="form-control" 
                       value="<?php echo htmlspecialchars($produto['nome'] ?? ''); ?>" 
                       placeholder="Ex: Ração Golden 15kg" required>
            </div>

            <div class="form-group">
                <label for="preco">Preço (R$):</label>
                <input type="number" step="0.01" name="preco" id="preco" class="form-control" 
                       value="<?php echo $produto['preco'] ?? ''; ?>" 
                       placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" class="form-control" required>
                    <option value="">Selecione...</option>
                    <?php 
                        $cats = ['Cachorro', 'Gato', 'Aves', 'Remédios'];
                        $atual = $produto['categoria'] ?? '';
                        
                        foreach($cats as $c) {
                            $selected = ($atual === $c) ? 'selected' : '';
                            echo "<option value='$c' $selected>$c</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Produto:</label>
                <input type="file" name="imagem" id="imagem" class="form-control" accept="image/*">
                <?php if(!empty($produto['imagem_principal'])): ?>
                    <small style="color: #888; display: block; margin-top: 5px;">
                        Atual: <?php echo explode(',', $produto['imagem_principal'])[0]; ?>
                    </small>
                <?php endif; ?>
                <small style="color: #888;">Deixe em branco para manter a imagem atual.</small>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição Detalhada:</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="6" 
                          placeholder="Detalhes técnicos..."><?php echo htmlspecialchars($produto['descricao_longa'] ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-check-lg"></i> Salvar Dados
            </button>
            
            <a href="admin-produtos.php" class="btn-cancel">Cancelar e Voltar</a>
            
        </form>
    </div>
</main>

<?php 
// Inclusão do Rodapé usando $path
require_once $path . 'app/includes/footer.php'; 
?>