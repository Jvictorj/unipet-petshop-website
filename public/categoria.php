<?php
// 1. Configuração Inicial
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
// O arquivo está em public/categoria.php, então sobe um nível para a raiz
$path = '../'; 

// Regra 1: Includes (Conexão e Funções) corrigidos com $path
require_once $path . 'app/includes/functions.php';
require_once $path . 'app/config/conexao.php';

// 2. Filtros
$tipo = isset($_GET['tipo']) ? ucfirst(trim($_GET['tipo'])) : 'Todos';
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : ''; 

// Variáveis padrão
$bannerImg = "todososprodutosbanner.png";
$tituloPagina = "Todos os Produtos";

// 3. Lógica de Busca no Banco de Dados
try {
    $params = [];
    $sql = "SELECT * FROM produtos WHERE 1=1"; 

    if (!empty($busca)) {
        $tituloPagina = "Resultados para: " . htmlspecialchars($busca);
        $termos = array_values(array_filter(explode(' ', $busca)));

        if (count($termos) > 0) {
            $sql .= " AND (";
            foreach ($termos as $index => $termo) {
                if ($index > 0) $sql .= " AND ";
                $phNome = ":nome{$index}";
                $phDesc = ":desc{$index}";
                $sql .= "(nome LIKE $phNome OR descricao_curta LIKE $phDesc)";
                $params["nome{$index}"] = "%{$termo}%";
                $params["desc{$index}"] = "%{$termo}%";
            }
            $sql .= ")";
        }
    } 
    elseif ($tipo !== 'Todos') {
        $sql .= " AND categoria = :cat";
        $params['cat'] = $tipo;
        $tituloPagina = $tipo;
        $bannerImg = strtolower($tipo) . ".png"; 
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro no Banco de Dados: " . $e->getMessage());
}

// 4. Configuração do Header
$pageTitle = "Unipet - " . $tituloPagina;
$pageCss = [$path . 'assets/css/paginacategoria.css'];

require_once $path . 'app/includes/header.php';
?>

<section class="banner">
    <div class="banner-content">
        <div class="banner-box">
            <img class="img-desktop" src="<?php echo $path; ?>assets/img/banneracategoria/<?php echo $bannerImg; ?>" 
                 alt="Banner <?php echo $tituloPagina; ?>"
                 onerror="this.src='<?php echo $path; ?>assets/img/banneracategoria/todososprodutosbanner.png';">
        </div>
    </div>
</section>

<main>
    <section class="secao produto">
        <div class="containerproducts">
            
            <h2 style="text-align: center; margin-top: 20px; color: #fb3997; font-size: 2rem;">
                <?php echo $tituloPagina; ?>
            </h2>

            <?php if (count($produtos) > 0): ?>
                <ul class="lista-grid">
                    <?php foreach ($produtos as $prod): ?>
                        
                        <?php 
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

                        <li>
                            <div class="card-produto">
                                <div class="card-banner img-holder">
                                    <a href="produto.php?id=<?php echo $prod['id']; ?>">
                                        <img src="<?php echo $path; ?>assets/img/produtos/<?php echo $capa; ?>" 
                                             alt="<?php echo $prod['nome']; ?>" 
                                             class="img-cover default">
                                    </a>
                                </div>

                                <div class="card-conteudo">
                                    <h3 class="h3">
                                        <a href="produto.php?id=<?php echo $prod['id']; ?>" class="card-titulo">
                                            <?php echo $prod['nome']; ?>
                                        </a>
                                    </h3>
                                    
                                    <data class="card-preco" value="<?php echo $prod['preco']; ?>">
                                        R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?>
                                    </data>
                                    
                                    <div class="btncomprar">
                                        <button class="comprar">
                                            <a href="produto.php?id=<?php echo $prod['id']; ?>" style="color: white; text-decoration: none;">Comprar</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div style="text-align: center; padding: 50px;">
                    <i class="bi bi-search" style="font-size: 3rem; color: #ccc;"></i>
                    <h3 style="color: #666; margin-top: 10px;">Nenhum produto encontrado.</h3>
                    <p>Verifique a ortografia ou tente termos mais gerais.</p>
                    <a href="categoria.php?tipo=Todos" style="display: inline-block; margin-top: 15px; color: #fb3997; font-weight: bold;">Ver todos os produtos</a>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php require_once $path . 'app/includes/footer.php'; ?>