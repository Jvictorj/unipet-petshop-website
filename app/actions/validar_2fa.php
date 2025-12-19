<?php
session_start();

// 1. Importa conexão e funções
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/functions.php';

// 2. Segurança: Se ninguém tentou logar antes, expulsa para o login
if (!isset($_SESSION['pending_user_id'])) {
    header('Location: ../../public/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega o dado digitado no formulário do 2fa.php
    $respostaUsuario = isset($_POST['cpf_ou_nomeMaterno']) ? sanitizeInput($_POST['cpf_ou_nomeMaterno']) : '';
    $userId = $_SESSION['pending_user_id'];

    try {
        // Busca os dados de segurança do usuário no banco
        $stmt = $pdo->prepare("SELECT id, nivel_acesso, cpf, nome_materno FROM usuario WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $userId]);
        $user = $stmt->fetch();

        if ($user) {
            // Lógica de Validação (Comparação insensível a maiúsculas/minúsculas)
            $cpfCorreto = $user['cpf'];
            $maeCorreta = strtolower(trim($user['nome_materno']));
            $respostaUsuarioLower = strtolower(trim($respostaUsuario));

            if ($respostaUsuario === $cpfCorreto || $respostaUsuarioLower === $maeCorreta) {
                
                // --- SUCESSO: A RESPOSTA ESTÁ CORRETA ---
                
                // 1. Efetiva o login na sessão oficial
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nivel_acesso'] = $user['nivel_acesso'];
                
                // 2. Remove o ID pendente (não precisamos mais dele)
                unset($_SESSION['pending_user_id']);

                // 3. Registra LOG de Login com Sucesso
                registrarLog($pdo, $user['id'], 'LOGIN_SUCCESS', 'Login completo realizado com sucesso (2FA OK).');

                // 4. Redireciona para o Painel
                header('Location: ../../public/painel.php');
                exit;
            }
        }

        // --- ERRO: DADOS INCORRETOS ---
        registrarLog($pdo, $userId, 'LOGIN_FAIL_2FA', 'Falha no 2FA: Resposta incorreta.');
        $_SESSION['errors'] = ['CPF ou Nome Materno incorretos. Tente novamente.'];
        header('Location: ../../public/2fa.php');
        exit;

    } catch (PDOException $e) {
        $_SESSION['errors'] = ['Erro interno ao validar. Tente mais tarde.'];
        header('Location: ../../public/2fa.php');
        exit;
    }
} else {
    // Se tentar acessar o arquivo sem ser via POST
    header('Location: ../../public/2fa.php');
    exit;
}
?>