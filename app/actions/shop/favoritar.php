<?php
session_start();

// 1. Conexão com o Banco (Caminho absoluto via __DIR__ para evitar erros)
// Localização atual: app/actions/shop/favoritar.php
$caminhoConexao = __DIR__ . '/../../config/conexao.php';

if (file_exists($caminhoConexao)) {
    require_once $caminhoConexao;
} else {
    die("Erro: Arquivo de conexão não encontrado em: " . $caminhoConexao);
}

// 2. Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para a tela de login (Sobe 3 níveis para a raiz e entra em public/auth)
    header('Location: ../../../public/auth/login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: ../../../public/index.php');
    exit;
}

$userId = $_SESSION['user_id'];
$prodId = (int)$_GET['id'];
$origem = isset($_GET['origem']) ? $_GET['origem'] : 'produto'; 

try {
    // Verifica se já é favorito
    $stmt = $pdo->prepare("SELECT id FROM favoritos WHERE usuario_id = :uid AND produto_id = :pid");
    $stmt->execute(['uid' => $userId, 'pid' => $prodId]);

    if ($stmt->fetch()) {
        // REMOVER (Desfavoritar)
        $del = $pdo->prepare("DELETE FROM favoritos WHERE usuario_id = :uid AND produto_id = :pid");
        $del->execute(['uid' => $userId, 'pid' => $prodId]);
    } else {
        // ADICIONAR (Favoritar)
        $ins = $pdo->prepare("INSERT INTO favoritos (usuario_id, produto_id) VALUES (:uid, :pid)");
        $ins->execute(['uid' => $userId, 'pid' => $prodId]);
    }

} catch (PDOException $e) {
    die("Erro ao processar favorito: " . $e->getMessage());
}

// 3. Redirecionamento Inteligente (Caminhos de URL)
if ($origem === 'lista') {
    // Se veio da página Meus Favoritos (public/cliente/meus-favoritos.php)
    header("Location: ../../../public/cliente/meus-favoritos.php");
} else {
    // Se veio da página do Produto (public/produto.php)
    header("Location: ../../../public/produto.php?id=$prodId");
}
exit;
?>