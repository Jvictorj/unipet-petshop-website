<?php
// 1. Configuração e Dependências
session_start();
require_once '../app/includes/functions.php';
require_once '../app/includes/conexao.php';

// 2. Verifica ID
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id_produto = (int)$_GET['id'];

// 3. Busca o produto
try {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute(['id' => $id_produto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        echo "Produto não encontrado.";
        exit;
    }
} catch (PDOException $e) {
    die("Erro de conexão.");
}

// 4. Lógica de Favoritos
$ehFavorito = false;
if (isset($_SESSION['user_id'])) {
    $stmtFav = $pdo->prepare("SELECT id FROM favoritos WHERE usuario_id = :uid AND produto_id = :pid");
    $stmtFav->execute(['uid' => $_SESSION['user_id'], 'pid' => $id_produto]);
    if ($stmtFav->fetch()) {
        $ehFavorito = true;
    }
}

// --- 5. TRATAMENTO DAS IMAGENS (CORREÇÃO) ---
$img_str = $produto['imagem_principal'];
$lista_imagens = [];

if (!empty($img_str)) {
    // Separa a string onde tem vírgula
    $lista_imagens = explode(',', $img_str);
    // Remove espaços em branco extras
    $lista_imagens = array_map('trim', $lista_imagens);
} else {
    // Imagem padrão se não houver foto
    $lista_imagens = ['sem-foto.png']; 
}

// A primeira imagem é a capa
$imagem_capa = $lista_imagens[0];

// 6. Definições da Página
$pageTitle = "Unipet - " . $produto['nome'];
$pageCss = ['../assets/css/produto.css']; 

require_once '../app/includes/header.php';
?>

<main>
    <section class="container-produto" id="produto-detalhes">
        
        <div class="produto-container">
            <div class="produto-slider">
                <img class="produto-img" src="../assets/img/produtos/<?php echo $imagem_capa; ?>" id="MainImg" alt="<?php echo $produto['nome']; ?>">
                
                <?php if(count($lista_imagens) > 1): ?>
                    <button class="nav-btn nav-btn-left" onclick="Imagem_Anterior()">&#10094;</button>
                    <button class="nav-btn nav-btn-right" onclick="Proxima_Imagem()">&#10095;</button>
                <?php endif; ?>
            </div>

            <div class="thumbnail-container">
                <?php foreach($lista_imagens as $index => $img): ?>
                    <button class="thumbnail-img-btn" onclick="Mostrar_Imagem(<?php echo $index; ?>)">
                        <img class="thumbnail-img <?php echo $index === 0 ? 'active' : ''; ?>" 
                             src="../assets/img/produtos/<?php echo $img; ?>" 
                             alt="Foto <?php echo $index + 1; ?>">
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="detalhes">
            <p class="subtitulo">Categoria: <?php echo $produto['categoria']; ?></p>
            <h1 class="produto-titulo"><?php echo $produto['nome']; ?></h1>
            
            <div class="favorito-box" style="margin: 10px 0;">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="../app/acao/favoritar.php?id=<?php echo $produto['id']; ?>" class="fav-btn" title="Favoritar">
                        <i class="bi bi-heart<?php echo $ehFavorito ? '-fill' : ''; ?>" style="color: <?php echo $ehFavorito ? 'red' : 'gray'; ?>"></i>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="fav-btn"><i class="bi bi-heart"></i></a>
                <?php endif; ?>
            </div>

            <div class="preco-container">
                <div class="preco-detalhes">
                    <h1 class="preco-produto">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></h1>
                    <p class="preco-parcela">ou 2x de R$ <?php echo number_format($produto['preco']/2, 2, ',', '.'); ?> sem juros</p>
                    
                    <select name="opcao-produto" id="select-produto">
                        <option value="">Padrão (Unidade)</option>
                    </select>
                    
                    <form action="../app/acao/adicionar_carrinho.php" method="POST" style="display: flex; gap: 15px; align-items: center; margin-top: 20px;">
                        <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                        <input type="hidden" name="qtd" id="form-qtd" value="1">

                        <div class="quantity-input">
                            <button type="button" class="minus-btn" onclick="Diminuir_Valor()">-</button>
                            <input type="number" value="1" id="btn-input" min="1" readonly>
                            <button type="button" class="plus-btn" onclick="Aumentar_Valor()">+</button>
                        </div>

                        <button class="btn-add">
                            <i class="bi bi-cart2"></i> Adicionar ao Carrinho
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="descricao-simples" style="margin-top: 20px;">
               <p><?php echo $produto['descricao_curta'] ?? 'Produto de excelente qualidade.'; ?></p>
            </div>
        </div>
    </section>

    <section class="descricao" id="id-descricao">
        <div class="descricao-container">
            <h2 class="descricao-titulo">Descrição</h2>
            <div class="texto-descricao">
                <?php echo !empty($produto['descricao_longa']) ? nl2br($produto['descricao_longa']) : "Descrição detalhada não disponível."; ?>
            </div>
        </div>
    </section>

    <section id="especificaçao">
        <div class="container-espec">
            <h2 class="espec-titulo">Especificações</h2>
            <ul>
                <li class="especificaçao-li-gray">
                    <span class="spec-key">Idade</span>
                    <span class="spec-valor"><?php echo $produto['spec_idade'] ?? 'Todas'; ?></span>
                </li>
            </ul>
            <ul>
                <li class="especificaçao-li">
                    <span class="spec-key">Pet</span>
                    <span class="spec-valor"><?php echo $produto['categoria']; ?></span>
                </li>
            </ul>
            <ul>
                <li class="especificaçao-li-gray">
                    <span class="spec-key">Porte</span>
                    <span class="spec-valor"><?php echo $produto['spec_porte'] ?? 'Todos'; ?></span>
                </li>
            </ul>
        </div>
    </section>
</main>

<script src="../assets/js/produto.js"></script>

<?php require_once '../app/includes/footer.php'; ?>