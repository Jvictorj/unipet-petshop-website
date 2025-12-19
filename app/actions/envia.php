<?php
session_start();

// 1. Includes
require_once __DIR__ . '/../includes/functions.php';

// 2. Verifica Método
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 3. Sanitização
    $nome = sanitizeInput($_POST['nome']);
    $email = sanitizeInput($_POST['email']);
    $telefone = sanitizeInput($_POST['telefone']);
    $mensagem = sanitizeInput($_POST['mensagem']);

    $erros = [];

    // Validação simples
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erros[] = "Preencha os campos obrigatórios.";
    }

    if (empty($erros)) {
        // --- SIMULAÇÃO DE ENVIO DE E-MAIL ---
        // Em um servidor real, você usaria a função mail() ou PHPMailer aqui.
        // Exemplo: mail("unisuampet@gmail.com", "Contato Site - $nome", $mensagem);
        
        // Para fins de teste, vamos apenas dizer que deu certo.
        $_SESSION['success_msg'] = "Obrigado, $nome! Sua mensagem foi enviada com sucesso.";
        
        // Redireciona de volta para a página de contato
        header('Location: ../../public/contato.php');
        exit;
    } else {
        // Se houver erros, salva na sessão e devolve
        $_SESSION['errors'] = $erros;
        header('Location: ../../public/contato.php');
        exit;
    }
} else {
    // Acesso direto proibido
    header('Location: ../../public/contato.php');
    exit;
}
?>