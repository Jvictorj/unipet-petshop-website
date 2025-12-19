<?php
// 1. Configuração
session_start();
require_once '../app/includes/conexao.php';
require_once '../app/includes/functions.php';

// 2. Segurança
ensureAuthenticated();
if (!isset($_SESSION['user_nivel_acesso']) || !in_array($_SESSION['user_nivel_acesso'], ['admin', 'master'])) {
    header('Location: painel.php');
    exit;
}

// 3. Busca de Pedidos
$busca = isset($_GET['q']) ? sanitizeInput($_GET['q']) : '';

try {
    $sql = "SELECT p.*, u.nome_completo, u.cpf 
            FROM pedidos p
            JOIN usuario u ON p.usuario_id = u.id
            WHERE 1=1";
    
    $params = [];

    // Filtro por ID do Pedido ou CPF do Cliente
    if (!empty($busca)) {
        $sql .= " AND (p.id LIKE :busca OR u.cpf LIKE :busca)";
        $params['busca'] = "%$busca%";
    }

    $sql .= " ORDER BY p.data_pedido DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao buscar pedidos.");
}

$pageTitle = "Gerenciar Pedidos - Admin Unipet";
$pageCss = ['../assets/css/areacliente/clientestyle.css',
            '../assets/css/admin-style.css']; 

require_once '../app/includes/header.php';
?>

<main style="padding: 40px 20px;">
    <div class="contener-pai">
        
        <h2 style="color: #fb3997; border-bottom: 2px solid #fecf12; padding-bottom: 10px; margin-bottom: 20px;">
            <i class="bi bi-receipt"></i> Gerenciar Pedidos
        </h2>

        <div class="row">
            <div class="listas">
                <ul>
                    <li class="lista_func">
                        <a href="painel.php"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="lista_func" style="background-color: #fecf12;">
                        <a href="admin-pedidos.php" style="color: black;"><i class="bi bi-box-seam"></i> <span>Pedidos</span></a>
                    </li>
                    <li class="lista_func">
                        <a href="admin-produtos.php"><i class="bi bi-plus-circle"></i> <span>Produtos</span></a>
                    </li>
                    <li class="lista_func">
                        <a href="admin-contato.php"><i class="bi bi-headset"></i> <span>Suporte</span></a>
                    </li>
                </ul>
            </div>

            <div class="big-box" style="padding: 0; background: transparent; box-shadow: none;">
                
                <div class="busca" style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 20px;">
                    <form action="" method="GET" style="display: flex; gap: 10px;">
                        <input type="text" name="q" class="form-control" 
                               style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; flex: 1;" 
                               placeholder="Buscar por Nº do Pedido ou CPF..." 
                               value="<?php echo $busca; ?>">
                        <button type="submit" style="background: #333; color: white; border: none; padding: 0 20px; border-radius: 5px; cursor: pointer;">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9f9f9; color: #555; border-bottom: 2px solid #eee; text-align: left;">
                                <th style="padding: 15px;"># Pedido</th>
                                <th>Cliente</th>
                                <th>Data</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th style="text-align: center;">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($pedidos) > 0): ?>
                                <?php foreach ($pedidos as $ped): ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px; font-weight: bold;">#<?php echo $ped['id']; ?></td>
                                        <td>
                                            <?php echo $ped['nome_completo']; ?><br>
                                            <small style="color: #888;"><?php echo $ped['cpf']; ?></small>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($ped['data_pedido'])); ?></td>
                                        <td style="color: #28a745; font-weight: bold;">R$ <?php echo number_format($ped['valor_total'], 2, ',', '.'); ?></td>
                                        <td>
                                            <?php 
                                                $statusColor = '#6c757d'; // Pendente (cinza)
                                                if($ped['status'] == 'Pago') $statusColor = '#28a745'; // Verde
                                                if($ped['status'] == 'Enviado') $statusColor = '#17a2b8'; // Azul
                                            ?>
                                            <span style="background: <?php echo $statusColor; ?>; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8rem;">
                                                <?php echo $ped['status']; ?>
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            <a href="admin-pedido-detalhe.php?id=<?php echo $ped['id']; ?>" class="btn-ver" style="background: #333; color: white; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.8rem;">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="padding: 40px; text-align: center; color: #888;">
                                        <i class="bi bi-inbox" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                                        Nenhum pedido encontrado.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</main>

<?php require_once '../app/includes/footer.php'; ?>