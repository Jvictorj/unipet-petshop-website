<?php
session_start();

// 1. Importa conexão e funções (Paths corretos mantidos)
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../includes/functions.php';

// 2. Segurança
if (!isset($_SESSION['pending_user_id'])) {
    // CORREÇÃO: Caminho para login (public/auth/login.php)
    // Sair de actions -> app -> raiz -> public -> auth
    header('Location: ../../../public/auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostaUsuario = isset($_POST['cpf_ou_nomeMaterno']) ? sanitizeInput($_POST['cpf_ou_nomeMaterno']) : '';
    $userId = $_SESSION['pending_user_id'];

    try {
        $stmt = $pdo->prepare("SELECT id, nivel_acesso, cpf, nome_materno FROM usuario WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();

        if ($user) {
            $cpfCorreto = $user['cpf'];
            $maeCorreta = strtolower(trim($user['nome_materno']));
            $respostaUsuarioLower = strtolower(trim($respostaUsuario));

            if ($respostaUsuario === $cpfCorreto || $respostaUsuarioLower === $maeCorreta) {
                
                // --- SUCESSO ---
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nivel_acesso'] = $user['nivel_acesso'];
                unset($_SESSION['pending_user_id']);

                registrarLog($pdo, $user['id'], 'LOGIN_SUCCESS', 'Login completo (2FA OK).');

                // CORREÇÃO DO REDIRECIONAMENTO DE SUCESSO
                // Dependendo do nível, mandamos para pastas diferentes na public
                if($user['nivel_acesso'] === 'admin' || $user['nivel_acesso'] === 'master') {
                    header('Location: ../../../public/admin/painel.php');
                } else {
                    header('Location: ../../../public/cliente/painel.php');
                }
                exit;
            }
        }

        // --- ERRO ---
        registrarLog($pdo, $userId, 'LOGIN_FAIL_2FA', 'Falha no 2FA: Resposta incorreta.');
        $_SESSION['errors'] = ['CPF ou Nome Materno incorretos.'];
        
        // CORREÇÃO: Volta para public/auth/2fa.php
        header('Location: ../../../public/auth/2fa.php');
        exit;

    } catch (PDOException $e) {
        $_SESSION['errors'] = ['Erro interno ao validar.'];
        header('Location: ../../../public/auth/2fa.php');
        exit;
    }
} else {
    header('Location: ../../../public/auth/2fa.php');
    exit;
}
?>