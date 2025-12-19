<?php
session_start();

// 1. Caminhos do Backend (Arquivos do Sistema)
// __DIR__ já é o caminho absoluto, subir 2 níveis (/../../) está correto para chegar em app/
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../includes/functions.php';

// Registrar log antes de destruir a sessão
if(isset($_SESSION['user_id'])) {
    if(function_exists('registrarLog')) {
        registrarLog($pdo, $_SESSION['user_id'], 'LOGOUT', 'Usuário saiu do sistema.');
    }
}

// Limpar e destruir a sessão
session_unset();
session_destroy();

// 2. Caminhos do Frontend (Redirecionamento de URL)
// Saímos de auth -> actions -> app (3 níveis) para chegar na raiz do projeto
// IMPORTANTE: Removida a barra inicial para o caminho ser relativo à pasta do projeto
header('Location: ../../../public/auth/login.php');
exit;
?>