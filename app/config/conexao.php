<?php
// app/config/conexao.php

// Detecta se estamos rodando no computador (Localhost) ou na Internet
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    // Configuração XAMPP (Local)
    $host = 'localhost';
    $db   = 'unipet';
    $user = 'root';
    $pass = ''; 
} else {
    // Configuração INFINITYFREE (Online)
    // PREENCHA AQUI COM SEUS DADOS:
    $host = ''; 
    $user = ''; // Seu usuário do Painel (MySQL User Name)
    $pass = ''; // A senha que você criou ao abrir a conta (NÃO é a do banco, é a do painel)
    
    // O nome do banco geralmente é: id_do_usuario + nome_que_voce_deu
    // Exemplo: se você criou o banco 'unipet', fica: 
    $db   = ''; 
}

$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     
    PDO::ATTR_EMULATE_PREPARES   => false,                
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Em produção, evite mostrar o erro detalhado para o usuário, mas para debug ajuda:
    die("Erro de conexão: " . $e->getMessage());
}
?>
