<?php
session_start();

// 1. Caminhos do Backend (Arquivos)
// O arquivo está em: app/actions/auth/login.php
// __DIR__ pega o caminho atual. '/../../' sobe para 'app/'
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitização básica
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = $_POST['senha'];
    
    // Função que verifica o usuário no banco
    $user = loginUser($pdo, $login, $senha);

    if ($user) {
        // APENAS define o ID pendente. NÃO LOGA AINDA.
        $_SESSION['pending_user_id'] = $user['id'];
        
        // Log de tentativa
        // Certifique-se que a função registrarLog existe em functions.php
        if(function_exists('registrarLog')) {
            registrarLog($pdo, $user['id'], 'LOGIN_STEP_1', 'Senha correta. Aguardando 2FA.');
        }

        // 2. Caminhos do Frontend (URL)
        // Precisamos sair de: auth -> actions -> app (3 níveis)
        // Para chegar na raiz e entrar em public/auth/2fa.php
        header('Location: ../../../public/auth/2fa.php');
        exit;
    } else {
        $_SESSION['errors'] = ['Login ou senha inválidos.'];
        
        // Volta para a tela de login
        header('Location: ../../../public/auth/login.php');
        exit;
    }
} else {
    // Se tentar acessar direto sem ser POST, manda pro form
    header('Location: ../../../public/auth/login.php');
    exit;
}
?>