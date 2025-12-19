<?php
$host = 'localhost';
$db   = 'unipet';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

// Configuração da conexão (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     
    PDO::ATTR_EMULATE_PREPARES   => false,                
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro de conexão com o Banco de Dados. Tente novamente mais tarde.");
}
?>