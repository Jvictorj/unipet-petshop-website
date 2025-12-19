<?php
session_start();

// Tenta carregar a conexão ajustando o caminho caso necessário
if (file_exists('../includes/conexao.php')) {
    require_once '../includes/conexao.php';
} elseif (file_exists('../../app/includes/conexao.php')) {
    require_once '../../app/includes/conexao.php';
} else {
    die("Erro: Arquivo de conexão não encontrado em app/actions/favoritar.php");
}

// Verifica login
if (!isset($_SESSION['user_id'])) {
    // Salva a página atual para voltar depois do login (opcional)
    header('Location: ../../public/login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ../../public/index.php');
    exit;
}

$userId = $_SESSION['user_id'];
$prodId = (int)$_GET['id'];
$origem = isset($_GET['origem']) ? $_GET['origem'] : 'produto'; // Define de onde veio o clique

try {
    // 1. Verifica se já é favorito
    $stmt = $pdo->prepare("SELECT id FROM favoritos WHERE usuario_id = :uid AND produto_id = :pid");
    $stmt->execute(['uid' => $userId, 'pid' => $prodId]);

    if ($stmt->fetch()) {
        // REMOVER (Desfavoritar)
        $del = $pdo->prepare("DELETE FROM favoritos WHERE usuario_id = :uid AND produto_id = :pid");
        $del->execute(['uid' => $userId, 'pid' => $prodId]);
    } else {
        // ADICIONAR (Favoritar)
        // Se der erro de coluna 'data_adicionado' não encontrada, remova ela do Insert se for automático no banco
        $ins = $pdo->prepare("INSERT INTO favoritos (usuario_id, produto_id) VALUES (:uid, :pid)");
        $ins->execute(['uid' => $userId, 'pid' => $prodId]);
    }

} catch (PDOException $e) {
    // Se der erro, volta para a página anterior com erro (opcional) or die
    die("Erro ao processar favorito: " . $e->getMessage());
}

// 2. Redirecionamento Inteligente
if ($origem === 'lista') {
    // Se veio da página Meus Favoritos, volta para lá
    header("Location: ../../public/meus-favoritos.php");
} else {
    // Se veio da página do Produto, volta para o produto
    header("Location: ../../public/produto.php?id=$prodId");
}
exit;
?>