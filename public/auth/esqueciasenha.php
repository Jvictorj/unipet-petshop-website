<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes
require_once '../app/includes/functions.php';

// Se já estiver logado, não precisa recuperar senha
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

  <title>Unipet - Recuperar Senha</title>
  <meta name="description" content="Recupere sua senha na Unipet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="shortcut icon" href="../assets/img/favicon/icon-unipet.png" type="image/png">

  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="../assets/css/modal.css">
  <link rel="stylesheet" href="../assets/css/menufixo.css">
  <link rel="stylesheet" href="../assets/css/footer.css">

  <script src="../assets/js/slide.js" defer></script>
  <script src="../assets/js/modal.js" defer></script>
  <script src="../assets/js/menumobile.js" defer></script>
</head>

<body>
  <main>
    <div class="containermain container-background-image">
      
      <div class="containerform">
          <div class="containeresqueda">
              <div class="logoimglogin"> 
                  <a href="index.php">
                    <img src="../assets/img/fotoslogin/unipetdarkmode-removebg-preview.png" alt="logo unipet" id="logoimagemdarkmodee">
                  </a>
              </div>
              <div class="mensagemlogin">
                  <p>Faça a <b style="color: #ff7b00;">melhor escolha</b></p>
                  <p>para seu amigo(a)</p>
              </div>
          </div>
          
          <form action="../app/actions/solicitar_recuperacao.php" method="POST" class="containerdireita">
              <div class="tiltelogin">
                  <p><b>Informe seu e-mail abaixo que iremos lhe enviar o link de recuperação.</b></p>
              </div>
              
              <div class="input-box">
                  <input type="email" name="email" placeholder="Insira seu E-mail" required>
              </div>
           
              <div class="btnentrar">
                  <button type="submit">Redefinir Senha</button>
                  <a href="login.php">Voltar para Login</a>
              </div>
          </form>
      </div>
    </div>
  </main>

  <a id="link-topo" href="#">&#9650;</a>

  <script src="../assets/js/darkmode.js" defer></script>
</body>
</html>