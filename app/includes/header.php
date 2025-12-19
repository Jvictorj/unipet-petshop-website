<?php
// --- 1. CONFIGURAÇÃO DE CAMINHOS ---
// Define o caminho base para assets e includes dependendo de onde o arquivo é chamado
// Se a variável $path já existir (definida na página pai), usa ela. Se não, tenta descobrir.
if (!isset($path)) {
    // Se o arquivo atual está dentro de uma subpasta (ex: public/admin/painel.php)
    if (file_exists('../../assets')) {
        $path = '../../';
    } 
    // Se o arquivo atual está na raiz da public (ex: public/index.php)
    elseif (file_exists('../assets')) {
        $path = '../';
    } 
    // Fallback
    else {
        $path = '../';
    }
}

// --- 2. CONEXÃO COM BANCO (Mini-Cart) ---
if (!isset($pdo)) {
    // Tenta incluir usando o caminho base calculado
    $arqConexao = $path . 'app/includes/conexao.php';
    if (file_exists($arqConexao)) {
        require_once $arqConexao;
    }
}

// --- 3. LÓGICA DO CARRINHO (Modal) ---
$itensModal = [];
$totalModal = 0;
$qtdItensModal = 0;

if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0 && isset($pdo)) {
    try {
        $ids = implode(',', array_keys($_SESSION['carrinho']));
        // Verifica se há IDs válidos antes de consultar
        if (!empty($ids)) {
            $sqlModal = "SELECT id, nome, preco, imagem_principal FROM produtos WHERE id IN ($ids)";
            $stmtModal = $pdo->prepare($sqlModal);
            $stmtModal->execute();
            $resModal = $stmtModal->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resModal as $prod) {
                $qtd = $_SESSION['carrinho'][$prod['id']];
                $subtotal = $prod['preco'] * $qtd;
                $totalModal += $subtotal;
                $qtdItensModal += $qtd;

                // Tratamento imagem
                $img_str = $prod['imagem_principal'];
                $capa = "sem-foto.png";
                if (!empty($img_str)) {
                    $parts = explode(',', $img_str);
                    $capa = trim($parts[0]);
                }

                $itensModal[] = [
                    'id' => $prod['id'],
                    'nome' => $prod['nome'],
                    'preco' => $prod['preco'],
                    'imagem' => $capa,
                    'qtd' => $qtd
                ];
            }
        }
    } catch (Exception $e) {
        // Silêncio
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Unipet - Seu Pet Merece o Melhor'; ?></title>
    
    <link rel="shortcut icon" href="<?php echo $path; ?>assets/img/favicon/icon-unipet.png" type="image/x-icon">
    
    <link rel="stylesheet" href="<?php echo $path; ?>assets/css/menufixo.css">
    <link rel="stylesheet" href="<?php echo $path; ?>assets/css/modal.css">
    <link rel="stylesheet" href="<?php echo $path; ?>assets/css/footer.css">
    <link rel="stylesheet" href="<?php echo $path; ?>assets/css/darkmode.css">

    <?php if (isset($pageCss) && is_array($pageCss)): ?>
        <?php foreach ($pageCss as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <script src="<?php echo $path; ?>assets/js/menumobile.js" defer></script> <script src="<?php echo $path; ?>assets/java/menu.js" defer></script> <script src="<?php echo $path; ?>assets/java/modal.js" defer></script>
    <script src="<?php echo $path; ?>assets/java/darkmode.js" defer></script>
</head>
<body>
    
  <header class="header-desktop">
    <nav class="navbar">
      <div class="containernav">
        
        <div class="logoimg"> 
          <a href="<?php echo $path; ?>public/index.php">
              <img src="<?php echo $path; ?>assets/img/unipet.png" alt="Logo Unipet" id="logoimagem">
          </a>
          <a href="<?php echo $path; ?>public/index.php">
              <img src="<?php echo $path; ?>assets/img/unipetdarkmode.png" alt="Logo Unipet Dark" id="logoimagemdarkmode">
          </a>
        </div>

        <form method="GET" action="<?php echo $path; ?>public/categoria.php" class="areainput">
          <div class="imglupa">
            <button type="submit"><img src="<?php echo $path; ?>assets/img/imagem-menu/lupapng.png" alt="Buscar" id="lupaimagem"></button>
          </div>
          <div class="inputsearch">
            <input type="text" name="busca" placeholder="Digite aqui o que seu pet precisa!" id="inputsearch">
          </div>
        </form>

        <div class="iconeslogin">
          <div class="iconlogin">
              <a href="<?php echo $path; ?>public/contato.php" title="Contato">
                  <i class="bi bi-telephone-fill" style="font-size:20px;"></i>
              </a>
          </div>
          
          <div class="iconlogin">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="<?php echo $path; ?>public/cliente/meus-favoritos.php" title="Meus Favoritos"><i class="bi bi-heart" style="font-size:20px;"></i></a>
            <?php else: ?>
                <a href="<?php echo $path; ?>public/auth/login.php" title="Login"><i class="bi bi-heart" style="font-size:20px;"></i></a>
            <?php endif; ?>
          </div>

          <div class="iconlogin" style="position: relative;">
              <button id="open-modal" title="Carrinho">
                  <i class="bi bi-cart2" style="font-size:20px;"></i>
                  <?php if($qtdItensModal > 0): ?>
                    <span style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px;">
                        <?php echo $qtdItensModal; ?>
                    </span>
                  <?php endif; ?>
              </button>
          </div>
          
          <div id="fade" class="hide"></div>
          <div id="modal" class="hide">
            <div class="modal-header">
              <h2 class="titlemodal">Seu Carrinho</h2>
              <button id="close-modal"><i class="bi bi-x" style="font-size:40px;"></i></button>
            </div>
            <hr class="hrmodal">
            
            <div class="modal-body">
                <div class="container-modal">
                  
                  <?php if(count($itensModal) > 0): ?>
                      <div class="lista-modal" style="max-height: 300px; overflow-y: auto; width: 100%;">
                          <?php foreach($itensModal as $item): ?>
                              <div class="item-modal" style="display: flex; gap: 10px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; align-items: center;">
                                  <img src="<?php echo $path; ?>assets/img/produtos/<?php echo $item['imagem']; ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                  <div style="flex: 1; text-align: left;">
                                      <p style="font-size: 0.9rem; margin: 0; font-weight: bold;"><?php echo $item['nome']; ?></p>
                                      <p style="font-size: 0.8rem; margin: 0; color: #666;">
                                          <?php echo $item['qtd']; ?>x R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                                      </p>
                                  </div>
                                  <a href="<?php echo $path; ?>app/actions/shop/remover_carrinho.php?id=<?php echo $item['id']; ?>" style="color: red;"><i class="bi bi-trash"></i></a>
                              </div>
                          <?php endforeach; ?>
                      </div>

                      <div class="total-modal" style="margin-top: 10px; text-align: right;">
                          <p style="font-size: 1.2rem; font-weight: bold; color: #ed6335;">Total: R$ <?php echo number_format($totalModal, 2, ',', '.'); ?></p>
                      </div>

                      <div class="buttonmodal" style="margin-top: 15px;">
                          <a href="<?php echo $path; ?>public/cliente/carrinho.php" style="text-decoration: none;">
                              <button class="btnmodal" style="width: 100%;">Ir para Pagamento</button>
                          </a>
                      </div>

                  <?php else: ?>
                      <div class="paragrafo1"><p><b>Seu carrinho está vazio</b></p></div>
                      <div class="sacola-modal"> <i class="bi bi-cart-x" style="font-size:40px; color: #ccc;"></i></div>
                      <div class="paragrafo1"><p>Navegue pela loja e adicione produtos.</p></div>
                      <div class="buttonmodal">
                          <button class="btnmodal" onclick="document.getElementById('close-modal').click()">Continuar Comprando</button>
                      </div>
                  <?php endif; ?>

                </div>
            </div>
          </div>
          
          <div class="iconlogin">
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php 
                    $painelLink = ($path . 'public/cliente/painel.php');
                    if(isset($_SESSION['user_nivel_acesso']) && in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
                        $painelLink = ($path . 'public/admin/painel.php'); // Se tiver painel admin separado
                    }
                ?>
                <a href="<?php echo $path; ?>public/cliente/painel.php" title="Meu Perfil"><i class="bi bi-person-check-fill" style="font-size:20px;"></i></a>
                <a href="<?php echo $path; ?>app/actions/auth/logout.php" title="Sair" style="margin-left: 10px;"><i class="bi bi-box-arrow-right" style="font-size:20px;"></i></a>
            <?php else: ?>
                <a href="<?php echo $path; ?>public/auth/login.php" title="Entrar"><i class="bi bi-person" style="font-size:20px;"></i></a>
            <?php endif; ?>
          </div>
          
          <div>
              <i id="icon-dark-mode" class="bi bi-moon-fill" style="cursor: pointer; margin-left: 10px;"></i>
              <i id="icon-light-mode" class="bi bi-sun-fill" style="cursor: pointer; margin-left: 10px;"></i>
          </div>    
        </div>
      </div>

      <div class="areadeservico">
        <ul class="ul-dropdown">
          <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/categoria.php?tipo=Todos"><b>Todos os Produtos</b></a></div></li>
          <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/categoria.php?tipo=Cachorro"><b>Cachorro</b></a></div></li>
          <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/categoria.php?tipo=Gato"><b>Gato</b></a></div></li>
          <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/categoria.php?tipo=Aves"><b>Pássaro</b></a></div></li>
          <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/categoria.php?tipo=Remédios"><b>Remédios</b></a></div></li>
          <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/doacao.php"><b>Doação</b></a></div></li>
          <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/quemsomos.php"><b>Unipet</b></a></div></li>
        </ul>
      </div>  
    </nav>
  </header>

  <header class="header-mobile">
      <nav class="navbar">
        <div class="containernav">
            <div class="containertop">
                 <div class="iconmobile"><button id="btn-menu"><i class="bi bi-list" style="font-size:40px;"></i></button></div>
                 <div class="containerlogo">
                     <a href="<?php echo $path; ?>public/index.php"><img src="<?php echo $path; ?>assets/img/unipet.png" id="logoimagem"></a>
                 </div>
            </div>
            
            <form method="GET" action="<?php echo $path; ?>public/categoria.php" class="areainput">
              <div class="imglupa"><button type="submit"><img src="<?php echo $path; ?>assets/img/imagem-menu/lupapng.png"></button></div>
              <div class="inputsearch"><input type="text" name="busca" placeholder="O que seu pet precisa?"></div>
            </form>

            <div class="menu-mobile" id="menu-mobile">
                <div class="arealoginmobile">
                    <div class="btn-fechar" id="btn-fechar"><i class="bi bi-x" style="font-size: 40px;"></i></div>
                </div>
                <nav>
                    <ul>
                        <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/categoria.php?tipo=Todos">Todos</a></div></li>
                        <li class="li-dropdown"><div class="dificil"><a href="<?php echo $path; ?>public/cliente/carrinho.php">Meu Carrinho</a></div></li> 
                        </ul>
                </nav>
            </div>
            <div class="overlay-menu" id="overlay-menu"></div>
        </div>
      </nav>
  </header>