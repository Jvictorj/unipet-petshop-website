<?php
session_start();

if (isset($_GET['id']) && isset($_GET['operacao'])) {
    $id = (int)$_GET['id'];
    $operacao = $_GET['operacao'];

    if (isset($_SESSION['carrinho'][$id])) {
        if ($operacao === 'aumentar') {
            $_SESSION['carrinho'][$id]++;
        } elseif ($operacao === 'diminuir') {
            $_SESSION['carrinho'][$id]--;
            // Se chegar a zero, remove do carrinho
            if ($_SESSION['carrinho'][$id] < 1) {
                unset($_SESSION['carrinho'][$id]);
            }
        }
    }
}

header('Location: ../../../public/carrinho.php');
exit;