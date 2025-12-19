<?php
// 1. Configuração Inicial
session_start();
require_once '../app/includes/functions.php';
require_once '../app/includes/conexao.php';

// 2. Filtros
// Limpa os dados de entrada
$tipo = isset($_GET['tipo']) ? ucfirst(trim($_GET['tipo'])) : 'Todos';
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : ''; 

// Variáveis padrão
$bannerImg = "todososprodutosbanner.png";
$tituloPagina = "Todos os Produtos";

// 3. Lógica de Busca no Banco de Dados
try {
    $params = [];
    $sql = "SELECT * FROM produtos WHERE 1=1"; // Base da query

    // --- CENÁRIO 1: BUSCA POR PALAVRA CHAVE ---
    if (!empty($busca)) {
        $tituloPagina = "Resultados para: " . htmlspecialchars($busca);
        
        // 1. Explode: Separa as palavras
        // 2. Filter: Remove espaços vazios
        // 3. Values: REORGANIZA os índices (0, 1, 2...) <- CORREÇÃO DO ERRO
        $termos = array_values(array_filter(explode(' ', $busca)));

        if (count($termos) > 0) {
            $sql .= " AND (";

            foreach ($termos as $index => $termo) {
                if ($index > 0) {
                    $sql .= " AND ";
                }

                $phNome = ":nome{$index}";
                $phDesc = ":desc{$index}";

                $sql .= "(nome LIKE $phNome OR descricao_curta LIKE $phDesc)";

                $params["nome{$index}"] = "%{$termo}%";
                $params["desc{$index}"] = "%{$termo}%";
            }

    $sql .= ")";
}

    } 
    // --- CENÁRIO 2: FILTRO POR CATEGORIA ---
    elseif ($tipo !== 'Todos') {
        $sql .= " AND categoria = :cat";
        $params['cat'] = $tipo; // Chave sem ':' para evitar bugs de versão PDO
        $tituloPagina = $tipo;
        
        // Define banner dinâmico
        $bannerImg = strtolower($tipo) . ".png"; 
    }
    // --- CENÁRIO 3: MOSTRAR TUDO (Já está no padrão) ---

    // Executa a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Em caso de erro, mostre a mensagem técnica (apenas para debug)
    die("Erro no Banco de Dados: " . $e->getMessage());
}

// 4. Configuração do Header
$pageTitle = "Unipet - " . $tituloPagina;
$pageCss = ['../assets/css/paginacategoria.css'];

require_once '../app/includes/header.php';
?>

<section class="banner">
    <div class="banner-content">
        <div class="banner-box">
            <img class="img-desktop" src="../assets/img/banneracategoria/<?php echo $bannerImg; ?>" 
                 alt="Banner <?php echo $tituloPagina; ?>"
                 onerror="this.src='../assets/img/banneracategoria/todososprodutosbanner.png';">
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
                            // Tratamento de Imagem para a Vitrine (Pega a primeira da lista)
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
                                        <img src="../assets/img/produtos/<?php echo $capa; ?>" 
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

<?php require_once '../app/includes/footer.php'; ?>