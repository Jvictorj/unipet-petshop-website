<?php
// 1. Iniciar sessão
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
// Define que estamos 2 níveis abaixo da raiz (public/cliente/)
$path = '../../'; 

// 2. Includes (Conexão e Funções)
require_once $path . 'app/includes/functions.php';
require_once $path . 'app/config/conexao.php';

// Segurança: Apenas logados
// Se a função ensureAuthenticated não existir, usa ensureUser ou verificação manual
if (function_exists('ensureAuthenticated')) {
    ensureAuthenticated();
} elseif (function_exists('ensureUser')) {
    ensureUser();
} elseif (!isset($_SESSION['user_id'])) {
    header('Location: ' . $path . 'public/auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Busca os produtos favoritos do usuário
try {
    // SQL Ajustado
    $sql = "SELECT p.*, f.data_adicionado, f.id as fav_id
            FROM produtos p 
            INNER JOIN favoritos f ON p.id = f.produto_id 
            WHERE f.usuario_id = :uid 
            ORDER BY f.id DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['uid' => $user_id]);
    $favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro técnico ao carregar favoritos: <br>" . $e->getMessage());
}

$pageTitle = "Meus Favoritos | Unipet";

// CSS Específico (Corrigido com $path)
$pageCss = [$path . 'assets/css/favoritos.css']; 

require_once $path . 'app/includes/header.php';
?>

<main>
    <section class="container-favoritos">
        <div class="cabecalho-fav">
            <h1><i class="bi bi-heart-fill"></i> Meus Favoritos</h1>
            <p>Produtos que você amou e salvou para depois.</p>
        </div>

        <?php if (count($favoritos) > 0): ?>
            <div class="grid-favoritos">
                <?php foreach ($favoritos as $prod): 
                    // Tratamento de imagem
                    $img_str = $prod['imagem_principal'];
                    $capa = "sem-foto.png";
                    if (!empty($img_str)) {
                         if (strpos($img_str, ',') !== false) {
                            $imgs = explode(',', $img_str);
                            $capa = trim($imgs[0]);
                         } else {
                            $capa = trim($img_str);
                         }
                    }
                ?>
                    <div class="card-fav">
                        <div class="img-area">
                            <a href="../produto.php?id=<?php echo $prod['id']; ?>">
                                <img src="<?php echo $path; ?>assets/img/produtos/<?php echo $capa; ?>" alt="<?php echo $prod['nome']; ?>">
                            </a>
                            
                            <a href="<?php echo $path; ?>app/actions/shop/favoritar.php?id=<?php echo $prod['id']; ?>&origem=lista" 
                               class="btn-remove" 
                               title="Remover dos favoritos">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                        <div class="info-area">
                            <h3><?php echo $prod['nome']; ?></h3>
                            <p class="preco">R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?></p>
                            
                            <a href="../produto.php?id=<?php echo $prod['id']; ?>" class="btn-ver">Ver Produto</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="vazio-fav">
                <i class="bi bi-heart-break" style="font-size: 3rem; color: #ccc;"></i>
                <h3 style="color: #666; margin-top: 15px;">Você ainda não tem favoritos.</h3>
                <a href="../categoria.php?tipo=Todos" style="display:inline-block; margin-top:15px; color: #fb3997; font-weight: bold;">Explorar Loja</a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php require_once $path . 'app/includes/footer.php'; ?>