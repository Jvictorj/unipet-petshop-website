<?php 
session_start();

// 1. Includes corretos usando __DIR__
// Caminho: app/actions/auth/atualizar_senha.php
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../includes/functions.php';

// 2. Verificação de Segurança
if (!isset($_SESSION['user_id'])) {
    // Redireciona para a nova localização do login
    header('Location: ../../../public/auth/login.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    // Validação simples
    if ($nova_senha !== $confirma_senha) {
        $errors[] = 'As senhas não coincidem.';
    } elseif (strlen($nova_senha) < 6) {
        $errors[] = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        // Criptografa
        // Certifique-se que a função hashPassword existe em functions.php, senão use password_hash
        $senha_hash = function_exists('hashPassword') ? hashPassword($nova_senha) : password_hash($nova_senha, PASSWORD_DEFAULT);
        $user_id = $_SESSION['user_id'];

        try {
            // 3. Atualização usando PDO (Seguro)
            $stmt = $pdo->prepare('UPDATE usuario SET senha_hash = :senha WHERE id = :id');
            $stmt->execute([
                'senha' => $senha_hash, 
                'id' => $user_id
            ]);

            // Sucesso: Verifica o nível para redirecionar para o painel correto
            $redirectUrl = '../../../public/cliente/painel.php'; // Padrão
            
            if (isset($_SESSION['user_nivel_acesso']) && in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
                $redirectUrl = '../../../public/admin/painel.php';
            }

            header("Location: $redirectUrl?msg=" . urlencode('Senha atualizada com sucesso!'));
            exit;

        } catch (PDOException $e) {
            // Em produção, logar o erro: error_log($e->getMessage());
            $errors[] = 'Erro no banco de dados. Tente novamente.';
        }
    }
}

// Se deu erro, volta para o formulário na pasta auth
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../../../public/auth/atualizar-senha.php');
    exit;
}
?>