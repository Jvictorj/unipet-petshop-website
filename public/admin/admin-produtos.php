<?php
// 1. Configuração Inicial e Caminhos
session_start();

// O arquivo está em public/admin/, sobe dois níveis para a raiz
$path = '../../'; 

// Importação com caminhos corrigidos usando $path
require_once $path . 'app/config/conexao.php';
require_once $path . 'app/includes/functions.php';

// 2. Segurança: Apenas Logados
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
}

// 3. Verificação de Nível: Apenas Admin ou Master
if (!isset($_SESSION['user_nivel_acesso']) || !in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
    header('Location: ../cliente/painel.php'); 
    exit;
}

// 4. Busca produtos no banco
try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar produtos.");
}

$pageTitle = "Gerenciar Produtos";

// 5. Configuração de CSS usando $path
$pageCss = [
    $path . 'assets/css/areacliente/clientestyle.css',
    $path . 'assets/css/admin-style.css'
]; 

require_once $path . 'app/includes/header.php';
?>

<main style="padding: 40px 20px;">
    
    <?php if (isset($_SESSION['user_nivel_acesso']) && $_SESSION['user_nivel_acesso'] === 'master'): ?>
        <div class="master-banner" style="background: #333; color: #fff; padding: 20px; border-radius: 10px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
            <div class="master-info" style="display: flex; align-items: center; gap: 15px;">
                <i class="bi bi-shield-lock-fill" style="color: #fecf12; font-size: 2rem;"></i>
                <div>
                    <strong style="display: block;">Área Master</strong>
                    <span style="font-size: 0.8rem; color: #ccc;">Acesso exclusivo de Super Admin</span>
                </div>
            </div>
            
            <div class="master-actions" style="display: flex; gap: 10px;">
                <a href="master-usuarios.php" class="btn-master-outline" style="border: 1px solid #fecf12; color: #fecf12; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.8rem;">
                    <i class="bi bi-people"></i> Usuários
                </a>
                <a href="relatorios.php" class="btn-master-outline" style="border: 1px solid #fecf12; color: #fecf12; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.8rem;">
                    <i class="bi bi-file-earmark-bar-graph"></i> Logs
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="contener-pai">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #fecf12; padding-bottom: 10px; margin-bottom: 20px;">
            <h2 style="color: #fb3997; margin: 0;">Gerenciar Produtos</h2>
            <a href="admin-produto-form.php" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
                <i class="bi bi-plus-lg"></i> Novo Produto
            </a>
        </div>
        
        <div style="overflow-x: auto;"> 
            <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background: #fecf12; color: #333; text-transform: uppercase; font-size: 0.85rem;">
                        <th style="padding: 15px;">ID</th>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($produtos) > 0): ?>
                        <?php foreach ($produtos as $p): 
                            $img_str = $p['imagem_principal'];
                            $capa = (!empty($img_str) && strpos($img_str, ',') !== false) 
                                    ? explode(',', $img_str)[0] 
                                    : $img_str;
                        ?>
                        <tr style="border-bottom: 1px solid #eee; text-align: center;">
                            <td style="padding: 15px; color: #666;"><?php echo $p['id']; ?></td>
                            <td style="padding: 10px;">
                                <?php if(!empty($capa)): ?>
                                    <img src="<?php echo $path; ?>assets/img/produtos/<?php echo trim($capa); ?>" 
                                         width="50" height="50" style="object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                <?php else: ?>
                                    <span style="color: #ccc; font-size: 0.8rem;">Sem foto</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: left; font-weight: bold; color: #333;"><?php echo htmlspecialchars($p['nome']); ?></td>
                            <td><span style="background: #eee; padding: 3px 8px; border-radius: 10px; font-size: 0.8rem;"><?php echo htmlspecialchars($p['categoria']); ?></span></td>
                            <td style="color: #28a745; font-weight: bold;">R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?></td>
                            <td style="padding: 10px;">
                                <a href="admin-produto-form.php?id=<?php echo $p['id']; ?>" class="btn-action btn-edit" title="Editar" style="color: #007bff; margin-right: 10px; font-size: 1.2rem;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a href="<?php echo $path; ?>app/actions/produto_delete.php?id=<?php echo $p['id']; ?>" 
                                   onclick="return confirm('Tem certeza que deseja excluir este produto?')" 
                                   style="color: #dc3545; font-size: 1.2rem;" title="Excluir">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 30px; text-align: center; color: #666;">
                                <i class="bi bi-box-seam" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                Nenhum produto cadastrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="../cliente/painel.php" style="color: #666; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                <i class="bi bi-arrow-left"></i> Voltar ao Painel
            </a>
        </div>
    </div>
</main>

<?php require_once $path . 'app/includes/footer.php'; ?>