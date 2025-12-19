<?php
session_start();
require_once 'conexao.php'; 
require_once 'functions.php'; // Para usar registrarLog

if(isset($_SESSION['user_id'])) {
    registrarLog($pdo, $_SESSION['user_id'], 'LOGOUT', 'Usuário saiu do sistema.');
}

session_unset();
session_destroy();

header('Location: ../../public/login.php');
exit;
?>