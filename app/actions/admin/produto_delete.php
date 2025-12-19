<?php
session_start();
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/functions.php';

// Segurança: Apenas Admin ou Master
if (!isset($_SESSION['user_nivel_acesso']) || !in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
    header('Location: ../../public/painel.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Primeiro, busca o nome do produto para o log
    $stmtNome = $pdo->prepare("SELECT nome FROM produtos WHERE id = :id");
    $stmtNome->execute(['id' => $id]);
    $produto = $stmtNome->fetch();
    $nomeProduto = $produto ? $produto['nome'] : 'Desconhecido';

    try {
        // Exclui
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        // Registra Log
        registrarLog($pdo, $_SESSION['user_id'], 'EXCLUIR_PRODUTO', "Excluiu o produto ID $id ($nomeProduto)");
        
    } catch (PDOException $e) {
        // Erro silencioso ou redireciona com erro
    }
}

header('Location: ../../public/admin-produtos.php');
exit;
?>