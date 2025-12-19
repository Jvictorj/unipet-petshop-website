<?php
session_start();

// 1. Includes corretos
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta e sanitiza os dados vindos do formulário HTML
    $nome_completo = sanitizeInput($_POST['nome']);
    $data_nascimento = $_POST['data_nascimento']; // Datas geralmente não precisam de sanitize se vierem do type="date"
    $sexo = sanitizeInput($_POST['sexo']);
    $nome_materno = sanitizeInput($_POST['nomemae']);
    $cpf = sanitizeInput($_POST['cpf']);
    $email = sanitizeInput($_POST['email']);
    $telefone_celular = sanitizeInput($_POST['cell']);
    $telefone_fixo = sanitizeInput($_POST['tellfixo']);
    
    // Montagem do Endereço Completo (Juntando os campos do formulário)
    $cep = sanitizeInput($_POST['cep']);
    $bairro = sanitizeInput($_POST['bairro']);
    $cidade = sanitizeInput($_POST['cidade']);
    $estado = sanitizeInput($_POST['estado']);
    $endereco_completo = "$cep, $bairro, $cidade - $estado";

    $login = sanitizeInput($_POST['login']);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confsenha'];
    
    // Define nível padrão
    $nivel_acesso = 'cliente';

    // Validações Básicas
    if ($senha !== $confirma_senha) {
        $errors[] = 'As senhas não coincidem.';
    } elseif (strlen($senha) < 6) {
        $errors[] = 'A senha precisa ter pelo menos 6 caracteres.';
    } else {
        // Criptografa senha
        $senha_hash = hashPassword($senha);
        
        // Array de dados na ordem exata que a função registerUser (em functions.php) espera no SQL
        $userData = [
            $nome_completo, 
            $data_nascimento, 
            $sexo, 
            $nome_materno, 
            $cpf, 
            $email,
            $telefone_celular, 
            $telefone_fixo, 
            $endereco_completo, 
            $login, 
            $senha_hash, 
            $nivel_acesso 
        ];
        
        // Tenta registrar usando a conexão PDO ($pdo)
        if (registerUser($pdo, $userData)) {
            // Sucesso: Manda para o login com mensagem (opcional via GET ou Session)
            header('Location: ../../public/login.php');
            exit;
        } else {
            $errors[] = 'Erro ao registrar. Verifique se o CPF, Login ou E-mail já existem.';
        }
    }
}

// Tratamento de Erros
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    // Redireciona para o arquivo na pasta public
    header('Location: ../../public/cadastre-se.php');
    exit;
}
?>