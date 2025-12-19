<?php

// Inicia sessão se não existir
function startSessionIfNotStarted() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Limpa dados de entrada (Proteção XSS)
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Criptografa senha
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verifica senha
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Função de Registro (Adaptada para PDO)
function registerUser($pdo, $userData) {
    // Nota: $userData deve ser um array com os valores na ordem exata das colunas abaixo
    $sql = "INSERT INTO usuario (nome_completo, data_nascimento, sexo, nome_materno, cpf, email, telefone_celular, telefone_fixo, endereco_completo, login, senha_hash, nivel_acesso) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    try {
        $stmt = $pdo->prepare($sql);
        // O PDO permite passar o array direto no execute
        return $stmt->execute($userData);
    } catch (PDOException $e) {
        // Se der erro (ex: email duplicado), retorna o erro ou false
        // die($e->getMessage()); // Descomente para debugar
        return false; 
    }
}

// Função de Login (Adaptada para PDO)
function loginUser($pdo, $login, $senha) {
    $sql = "SELECT * FROM usuario WHERE login = :login LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['login' => $login]);
    
    $user = $stmt->fetch();

    // Se achou usuário E a senha bate
    if ($user && verifyPassword($senha, $user['senha_hash'])) {
        return $user;
    }
    return false;
}

// Proteção: Apenas Usuários Logados (Geral)
function ensureAuthenticated() {
    startSessionIfNotStarted();
    if (!isset($_SESSION['user_id'])) {
        // Como o arquivo está em 'public/', o login está na mesma pasta
        header('Location: login.php'); 
        exit;
    }
}

// Proteção: Apenas Clientes
function ensureUser() {
    startSessionIfNotStarted();
    // Verifica se NÃO está logado OU se o nível não é cliente
    if (!isset($_SESSION['user_id']) || $_SESSION['user_nivel_acesso'] !== 'cliente') {
        header('Location: login.php');
        exit;
    }
}

// Proteção: Apenas Admins
function euadm() {
    startSessionIfNotStarted();
    // Verifica se NÃO está logado OU se o nível não é admin
    if (!isset($_SESSION['user_id']) || $_SESSION['user_nivel_acesso'] !== 'admin') {
        header('Location: login.php'); // Redireciona cliente tentando acessar área adm
        exit;
    }
}

// Função para registrar logs no banco
function registrarLog($pdo, $userId, $acao, $descricao) {
    try {
        $stmt = $pdo->prepare("INSERT INTO logs_sistema (usuario_id, acao, descricao) VALUES (:uid, :acao, :desc)");
        $stmt->execute([
            'uid' => $userId,
            'acao' => $acao,
            'desc' => $descricao
        ]);
    } catch (PDOException $e) {
        // Falha silenciosa para não travar o site se o log falhar
    }
}
?>