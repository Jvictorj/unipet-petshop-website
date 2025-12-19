<?php
session_start();
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = sanitizeInput($_POST['login']);
    $senha = $_POST['senha'];
    
    $user = loginUser($pdo, $login, $senha);

    if ($user) {
        // APENAS define o ID pendente. NÃO LOGA AINDA.
        $_SESSION['pending_user_id'] = $user['id'];
        
        // Log de tentativa (opcional, pois ainda não entrou)
        registrarLog($pdo, $user['id'], 'LOGIN_STEP_1', 'Senha correta. Aguardando 2FA.');

        header('Location: ../../public/2fa.php');
        exit;
    } else {
        $_SESSION['errors'] = ['Login ou senha inválidos.'];
        header('Location: ../../public/login.php');
        exit;
    }
}
?>