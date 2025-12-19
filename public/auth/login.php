<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../../app/includes/functions.php';

// Verificação: Se o usuário já estiver logado, manda pro painel
if (isset($_SESSION['user_id'])) {
    header('Location: painel.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Unipet - Login</title>
  <meta name="description" content="Acesse sua conta na Unipet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="shortcut icon" href="../../assets/img/favicon/icon-unipet.png" type="image/png">

  <link rel="stylesheet" href="../../assets/css/login.css">
  <link rel="stylesheet" href="../../assets/css/modal.css">
  <link rel="stylesheet" href="../../assets/css/menufixo.css">
  <link rel="stylesheet" href="../../assets/css/footer.css">

  <script src="../../assets/js/validacao.js" defer></script>
</head>

<body>
  <div id="toast" class="hidden"></div>
  <div id="toast2" class="hidden"></div>

  <main>
    <div class="containermain container-background-image">
      <div class="containerform" id="form">
        
        <div class="containeresqueda">
          <div class="logoimglogin"> 
            <a href="index.php">
              <img src="../../assets/img/fotoslogin/unipetdarkmode-removebg-preview.png" alt="imglogo" id="logoimagemdarkmodee">
            </a>
          </div>
          <div class="mensagemlogin">
            <p>Faça a <b style="color: #ff7b00;">melhor escolha</b></p>
            <p>para seu amigo(a)</p>
          </div>
        </div>

        <?php
        if (!empty($_SESSION['errors'])) {
            echo "<div style='width: 100%; text-align: center; margin-bottom: 10px;'>";
            foreach ($_SESSION['errors'] as $error) {
                echo "<p style='color: white; background-color: #ff4d4d; padding: 5px; border-radius: 5px; display: inline-block;'>" . htmlspecialchars($error) . "</p>";
            }
            echo "</div>";
            unset($_SESSION['errors']);
        }
        ?>

        <form method="POST" action="../../app/actions/auth/login.php" class="containerdireita">
          <div class="tiltelogin">
            <p><b>Acesse usando seu Login ou CPF</b></p>
          </div>
          
          <div class="input-box">
            <input type="text" name="login" placeholder="Insira seu Login ou CPF" id="email-log" required>
          </div>
          
          <div class="input-box">
            <input type="password" name="senha" placeholder="Senha" id="senha-log" required>
          </div>
          
          <div class="esqueciminhasenha">
            <a href="esqueciasenha.php"><i class="bi bi-question-circle"></i> Esqueci minha senha</a>
          </div>
          
          <div class="btnentrar">
            <button type="submit" id="enviar">Entrar</button>
            
            <a href="register.php">Cadastre-se</a>
          </div>
          
          <div class="voltaraohome">
            <a href="../public/index.php">Voltar ao Início</a>
          </div>
        </form>
      </div>
    </div>
  </main>

  <a id="link-topo" href="#">&#9650;</a>

</body>
</html>