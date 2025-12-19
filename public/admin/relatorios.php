<?php
session_start();
require_once '../app/includes/conexao.php';
require_once '../app/includes/functions.php';
ensureAuthenticated();

if ($_SESSION['user_nivel_acesso'] !== 'master') { header('Location: painel.php'); exit; }

$logs = $pdo->query("
    SELECT l.*, u.nome_completo 
    FROM logs_sistema l 
    LEFT JOIN usuario u ON l.usuario_id = u.id 
    ORDER BY l.data_hora DESC LIMIT 100
")->fetchAll();

$pageTitle = "Logs do Sistema - Unipet";
$pageCss = ['../assets/css/master-style.css']; // CSS Novo
require_once '../app/includes/header.php';
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
                                <b><?= $log['nome_completo'] ?? 'Visitante/Sistema' ?></b><br>
                                <small style="color: #888;">ID: <?= $log['usuario_id'] ?? 'N/A' ?></small>
                            </td>
                            <td>
                                <span style="font-weight: bold; color: #fb3997;">
                                    <?= $log['acao'] ?>
                                </span>
                            </td>
                            <td style="color: #666;"><?= $log['descricao'] ?></td>
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

<?php require_once '../app/includes/footer.php'; ?>