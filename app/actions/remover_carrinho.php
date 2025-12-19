<?php
session_start();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Verifica se o produto existe na sessão e remove
    if (isset($_SESSION['carrinho'][$id])) {
        unset($_SESSION['carrinho'][$id]);
    }
}

// Volta para o carrinho
header('Location: ../../public/carrinho.php');
exit;