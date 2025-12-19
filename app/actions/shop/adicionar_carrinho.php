<?php
session_start();

// Verifica se os dados foram enviados via POST
if (isset($_POST['produto_id'])) {
    
    $id_produto = (int)$_POST['produto_id'];
    $qtd = isset($_POST['qtd']) ? (int)$_POST['qtd'] : 1;

    // Garante que a quantidade seja pelo menos 1
    if ($qtd < 1) {
        $qtd = 1;
    }

    // Inicializa o carrinho na sessão se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Se o produto já estiver no carrinho, soma a quantidade solicitada
    if (isset($_SESSION['carrinho'][$id_produto])) {
        $_SESSION['carrinho'][$id_produto] += $qtd;
    } else {
        // Se não, adiciona o novo produto com a quantidade inicial
        $_SESSION['carrinho'][$id_produto] = $qtd;
    }

    // Define uma mensagem opcional de sucesso (pode ser exibida via Toast no frontend)
    $_SESSION['sucesso_carrinho'] = "Produto adicionado com sucesso!";

    // --- REDIRECIONAMENTO ---
    // Sair de shop -> actions -> app (3 níveis) para acessar a raiz e entrar em public/
    header('Location: ../../../public/carrinho.php');
    exit;

} else {
    // Se tentar acessar o script diretamente via URL (GET), volta para a home
    header('Location: ../../../public/index.php');
    exit;
}