<?php
// 1. Iniciar sessão e conexões
session_start();

// --- CONFIGURAÇÃO DE CAMINHOS ---
$path = '../'; 

// Ajuste dos caminhos dos includes
require_once $path . 'app/includes/functions.php';
require_once $path . 'app/config/conexao.php'; // Caminho corrigido conforme sua árvore

$pageTitle = "Carrinho | Unipet";
$pageCss = [$path . 'assets/css/carrinho.css']; 

require_once $path . 'app/includes/header.php';

// 2. Lógica para buscar os produtos do carrinho
$produtos_no_carrinho = [];
$total_pedido = 0;

if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
    // Pega os IDs dos produtos salvos na sessão
    $ids = implode(',', array_keys($_SESSION['carrinho']));
    
    try {
        // Busca apenas os produtos que estão no carrinho
        $sql = "SELECT * FROM produtos WHERE id IN ($ids)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $produtos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($produtos_db as $prod) {
            $id = $prod['id'];
            $qtd = $_SESSION['carrinho'][$id];
            $subtotal = $prod['preco'] * $qtd;
            $total_pedido += $subtotal;

            // Tratamento da imagem
            $img_str = $prod['imagem_principal'];
            $capa = "sem-foto.png";
            if (!empty($img_str)) {
                $parts = explode(',', $img_str);
                $capa = trim($parts[0]);
            }

            $produtos_no_carrinho[] = [
                'id' => $id,
                'nome' => $prod['nome'],
                'preco' => $prod['preco'],
                'imagem' => $capa,
                'qtd' => $qtd,
                'subtotal' => $subtotal
            ];
        }
    } catch (PDOException $e) {
        echo "Erro ao carregar carrinho.";
    }
}
?>

<main>
    <section class="container" style="padding-top: 40px;">
        
        <div class="containerbox">
            <div class="title">
                <h1>Meu Carrinho</h1>
            </div>
            
            <div class="caixamensagem">
                <p>A Unipet oferece Garantia e Reembolso de até 30 dias em todos os produtos</p>
            </div>

            <div class="containertitle">
                <div class="titulo"><p>Produto</p></div>
                <div class="variaveis"><p>Preço</p></div>
                <div class="variaveis"><p>Qtd</p></div>
                <div class="variaveis"><p>Total</p></div>
                <div class="variaveis" style="width: 50px;"><p>Ação</p></div>
            </div>

            <div class="lista-produtos-carrinho" style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
                
                <?php if (count($produtos_no_carrinho) > 0): ?>
                    
                    <?php foreach ($produtos_no_carrinho as $item): ?>
                        <div class="containerproduto" style="display: flex; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            
                            <div class="titulo" style="display: flex; align-items: center; gap: 10px;">
                                <img src="<?php echo $path; ?>assets/img/produtos/<?php echo $item['imagem']; ?>" alt="Foto" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                <p style="font-size: 0.9rem; margin: 0;"><?php echo $item['nome']; ?></p>
                            </div>

                            <div class="variaveis">
                                <p>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                            </div>

                            <div class="variaveis">
                                <div style="display: flex; align-items: center; gap: 10px; border: 1px solid #ccc; border-radius: 5px; padding: 5px;">
                                    <a href="<?php echo $path; ?>app/actions/shop/atualizar_carrinho.php?id=<?php echo $item['id']; ?>&operacao=diminuir" 
                                    style="text-decoration: none; color: #333; font-weight: bold; padding: 0 5px;">-</a>
                                    
                                    <span><?php echo $item['qtd']; ?></span>
                                    
                                    <a href="<?php echo $path; ?>app/actions/shop/atualizar_carrinho.php?id=<?php echo $item['id']; ?>&operacao=aumentar" 
                                    style="text-decoration: none; color: #333; font-weight: bold; padding: 0 5px;">+</a>
                                </div>
                            </div>

                            <div class="variaveis">
                                <p><b>R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></b></p>
                            </div>

                            <div class="variaveis" style="width: 50px; text-align: center;">
                                <a href="<?php echo $path; ?>app/actions/shop/remover_carrinho.php?id=<?php echo $item['id']; ?>" style="color: red; font-size: 1.5rem;" title="Remover">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="containerproduto" style="justify-content: center; height: 150px; flex-direction: column; align-items: center;">
                        <i class="bi bi-cart-x" style="font-size: 3rem; color: #ccc;"></i>
                        <p style="margin-top: 10px;">Seu carrinho está vazio.</p>
                        <a href="index.php" style="color: #ed6335; margin-top: 5px; font-weight: bold;">Voltar para loja</a>
                    </div>
                <?php endif; ?>

            </div>

            <div class="containerrecomendacao">
                <div class="titlerecomendacao"> 
                    <h2>Você também pode gostar</h2>
                </div>
                <div class="conatinerrecomendacaoprodutos">
                     <p style="padding: 20px; color: #777;">Explore nossas categorias para achar novidades!</p>
                </div>
            </div>
        </div>

        <div class="containerbox02">
            <div class="title"><h1>Resumo</h1></div>
            
            <div class="inputcupom">
                <input type="text" placeholder="Digite seu Cupom">
            </div>

            <div class="resumopedido">
                <p><b>Valores</b></p>
            </div>

            <div class="pedidopreco">
                <p>Subtotal</p>
                <p>R$ <?php echo number_format($total_pedido, 2, ',', '.'); ?></p>
            </div>

            <div class="pedidopreco">
                <h2>Total</h2>
                <h2 style="color: #ed6335;">R$ <?php echo number_format($total_pedido, 2, ',', '.'); ?></h2>
            </div>

            <div class="btnaction">
                <?php if ($total_pedido > 0): ?>
                    <button class="btnpagamento" onclick="alert('Indo para checkout...')">Finalizar Compra</button>
                <?php else: ?>
                    <button class="btnpagamento" style="background: #ccc; cursor: not-allowed;" disabled>Carrinho Vazio</button>
                <?php endif; ?>
                
                <a href="index.php" class="btnescolher" style="text-decoration: none;">
                    Escolher mais produtos
                </a>
            </div>

            <hr>

            <div class="formadepagamentos">
                <p><b>Formas de Pagamento</b></p>
            </div>
            <div class="imgformadepagamentos">
                <div class="imgpagmentos">
                    <img src="<?php echo $path; ?>assets/img/payment.png" alt="Pagamentos" style="max-width: 100%;">
                </div>
            </div>
        </div>

    </section>
</main>

<?php require_once $path . 'app/includes/footer.php'; ?>