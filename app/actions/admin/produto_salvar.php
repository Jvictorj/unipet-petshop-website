<?php
session_start();
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = sanitizeInput($_POST['nome']);
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $desc = $_POST['descricao'];
    
    // Upload de Imagem (Simplificado)
    $imagemNome = null;
    if (!empty($_FILES['imagem']['name'])) {
        $imagemNome = time() . '_' . $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../../assets/img/produtos/' . $imagemNome);
    }

    if ($id) {
        // --- EDIÇÃO ---
        $sql = "UPDATE produtos SET nome=:nome, preco=:preco, categoria=:cat, descricao_longa=:desc";
        $params = ['nome' => $nome, 'preco' => $preco, 'cat' => $categoria, 'desc' => $desc, 'id' => $id];
        
        if ($imagemNome) {
            $sql .= ", imagem_principal=:img";
            $params['img'] = $imagemNome;
        }
        $sql .= " WHERE id=:id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        registrarLog($pdo, $_SESSION['user_id'], 'EDITAR_PRODUTO', "Editou o produto ID: $id ($nome)");

    } else {
        // --- CRIAÇÃO ---
        $sql = "INSERT INTO produtos (nome, preco, categoria, descricao_longa, imagem_principal) VALUES (:nome, :preco, :cat, :desc, :img)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nome' => $nome, 'preco' => $preco, 'cat' => $categoria, 'desc' => $desc, 'img' => $imagemNome ?? 'default.png'
        ]);
        
        registrarLog($pdo, $_SESSION['user_id'], 'CRIAR_PRODUTO', "Criou o produto: $nome");
    }

    header('Location: ../../public/admin-produtos.php');
}