<?php 
session_start();

// 1. Includes corretos usando __DIR__
require_once __DIR__ . '/../../includes/conexao.php';
require_once __DIR__ . '/../../includes/functions.php';

// 2. Verificação de Segurança
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../public/login.php');
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
        $senha_hash = hashPassword($nova_senha);
        $user_id = $_SESSION['user_id'];

        try {
            // 3. Atualização usando PDO (Seguro)
            $stmt = $pdo->prepare('UPDATE usuario SET senha_hash = :senha WHERE id = :id');
            $stmt->execute([
                'senha' => $senha_hash, 
                'id' => $user_id
            ]);

            // Sucesso: Manda para o painel com mensagem (opcional)
            header('Location: ../../public/painel.php?msg=Senha atualizada com sucesso!');
            exit;

        } catch (PDOException $e) {
            $errors[] = 'Erro no banco de dados. Tente novamente.';
        }
    }
}

// Se deu erro, volta para o formulário
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: ../../public/atualizar-senha.php');
    exit;
}
?>