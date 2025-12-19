<?php
session_start();

// Verifica se os dados foram enviados
if (isset($_POST['produto_id'])) {
    
    $id_produto = (int)$_POST['produto_id'];
    $qtd = isset($_POST['qtd']) ? (int)$_POST['qtd'] : 1;

    // Garante que a quantidade seja pelo menos 1
    if ($qtd < 1) {
        $qtd = 1;
    }

    // Inicializa o carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Se o produto já estiver no carrinho, soma a quantidade
    if (isset($_SESSION['carrinho'][$id_produto])) {
        $_SESSION['carrinho'][$id_produto] += $qtd;
    } else {
        // Se não, adiciona novo
        $_SESSION['carrinho'][$id_produto] = $qtd;
    }

    // Opcional: Definir uma mensagem de sucesso para exibir na próxima página
    // $_SESSION['msg_sucesso'] = "Produto adicionado ao carrinho!";

    // Redireciona para o Carrinho para o usuário ver o resultado
    header('Location: ../../public/carrinho.php');
    exit;

} else {
    // Se tentar acessar direto sem post, volta para a home
    header('Location: ../../public/index.php');
    exit;
}