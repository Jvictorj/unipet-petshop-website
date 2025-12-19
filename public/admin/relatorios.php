<?php
// Regra 2: Iniciar sessão
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/admin/, então sobe dois níveis para a raiz
$path = '../../'; 

// Regra 1: Includes (Conexão e Funções) usando $path
require_once $path . 'app/config/conexao.php'; 
require_once $path . 'app/includes/functions.php';

// Segurança: Apenas logados
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
}

// Verificação de Nível Master
if ($_SESSION['user_nivel_acesso'] !== 'master') { 
    header('Location: ../cliente/painel.php'); 
    exit; 
}

// Busca os logs (Query mantida)
$logs = $pdo->query("
    SELECT l.*, u.nome_completo 
    FROM logs_sistema l 
    LEFT JOIN usuario u ON l.usuario_id = u.id 
    ORDER BY l.data_hora DESC LIMIT 100
")->fetchAll();

$pageTitle = "Logs do Sistema - Unipet";

// CSS Específico (Caminho corrigido para assets/css/admin/ conforme seu tree)
$pageCss = [$path . 'assets/css/admin/master-style.css']; 

// Include do Cabeçalho
require_once $path . 'app/includes/header.php';
?>

<main class="master-main">
    <div class="master-container">
        
        <div class="master-header">
            <h1 class="master-title"><i class="bi bi-activity"></i> Relatórios de Atividade</h1>
            <a href="master-usuarios.php" class="btn-master">
                <i class="bi bi-arrow-left"></i> Voltar para Usuários
            </a>
        </div>

        <div class="table-responsive">
            <table class="master-table">
                <thead>
                    <tr>
                        <th>Data / Hora</th>
                        <th>Usuário</th>
                        <th>Ação</th>
                        <th>Descrição Detalhada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($logs) > 0): ?>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td style="white-space: nowrap; color: #555;">
                                <i class="bi bi-clock"></i> <?= date('d/m/Y H:i', strtotime($log['data_hora'])) ?>
                            </td>
                            <td>
                                <b><?= htmlspecialchars($log['nome_completo'] ?? 'Visitante/Sistema') ?></b><br>
                                <small style="color: #888;">ID: <?= $log['usuario_id'] ?? 'N/A' ?></small>
                            </td>
                            <td>
                                <span style="font-weight: bold; color: #fb3997;">
                                    <?= htmlspecialchars($log['acao']) ?>
                                </span>
                            </td>
                            <td style="color: #666;"><?= htmlspecialchars($log['descricao']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #999;">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i><br>
                                Nenhum log registrado ainda.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<?php 
// Inclusão do Rodapé usando $path
require_once $path . 'app/includes/footer.php'; 
?>