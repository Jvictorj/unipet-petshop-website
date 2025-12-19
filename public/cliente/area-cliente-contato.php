<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes
require_once '../app/includes/functions.php';

// Segurança: Apenas clientes logados
ensureUser();

$pageTitle = "Fale Conosco - Área do Cliente";

// CSS Específico desta página
// Certifique-se de mover seus arquivos CSS antigos para a pasta assets/css/areacliente/
$pageCss = [
    '../assets/css/areas/cliente/clientestyle.css',
    '../assets/css/areas/cliente/contato.css'
];

require_once '../app/includes/header.php';

// Captura nome do usuário da sessão para exibir na saudação
$nomeUsuario = $_SESSION['user_name'] ?? 'Cliente';
?>

<main>
    <div class="contener-pai">
        
        <div class="mensagem-boas-vinda">
            <span>
                Olá, <b><?php echo htmlspecialchars($nomeUsuario); ?></b>! Aqui você tem atendimento prioritário.
            </span>
            <a href="index.php">
                <button style="padding: 10px; cursor: pointer;">Voltar para a loja</button>
            </a>
        </div>

        <div class="row">
            <div class="listas">
                <ul>
                    <li class="lista_func">
                        <a href="painel.php">
                            <i class="bi bi-grid-fill"></i> <span>Painel Principal</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="meus-pedidos.php">
                            <i class="bi bi-bag"></i> <span>Meus pedidos</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="atualizar-senha.php">
                            <i class="bi bi-arrow-clockwise"></i> <span>Alterar senha</span>
                        </a>
                    </li>
                    <li class="lista_func">
                        <a href="dados-pessoais.php">
                            <i class="bi bi-person"></i> <span>Dados pessoais</span>
                        </a>
                    </li>
                    <li class="lista_func" style="background-color: #fecf12;">
                        <a href="area-cliente-contato.php" style="color: black;">
                            <i class="bi bi-envelope"></i> <span>Entre em contato</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="contenet-contato">
                <form action="../app/acao/envia.php" method="POST">
                    <div class="contener-inputs">
                        
                        <div class="inputs">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" value="<?php echo htmlspecialchars($nomeUsuario); ?>" readonly style="background-color: #eee;">
                        </div>

                        <div class="inputs">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" required placeholder="Seu e-mail de contato">
                        </div>

                        <div class="inputs">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" required placeholder="(XX) XXXXX-XXXX">
                        </div>

                        <div class="inputs">
                            <label for="mensagem">Mensagem</label>
                            <textarea name="mensagem" required style="width: 100%; height: 100px; padding: 10px;" placeholder="Como podemos ajudar?"></textarea>
                        </div>

                        <div class="inputs">
                            <button type="submit" style="background-color: #fb3997; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
                                Enviar Mensagem
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
// Inclusão do Rodapé
require_once '../app/includes/footer.php';
?>