<?php
// app/config/conexao.php

/**
 * Carrega variáveis de um arquivo tipo .env
 */
function loadEnv($path) {
    if (!file_exists($path)) return false;
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Pula comentários
        
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value);
            // Define também como variável de ambiente do sistema
            putenv(trim($name) . "=" . trim($value));
        }
    }
    return true;
}

// Tenta carregar .env (Local) ou config.env (Comum na InfinityFree)
$envPath = __DIR__ . '/../../.env';
$altEnvPath = __DIR__ . '/../../config.env';

if (!loadEnv($envPath)) {
    loadEnv($altEnvPath);
}

// Definição das variáveis (Prioridade para o arquivo carregado, senão padrão Localhost)
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? 'unipet';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // No servidor, não mostramos o erro real para o usuário
    error_log($e->getMessage());
    die("Desculpe, estamos com problemas técnicos de conexão.");
}