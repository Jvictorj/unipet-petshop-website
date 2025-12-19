<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/conexao.php';
require_once '../app/includes/functions.php';

// Segurança: Se não houver um login pendente (parcial), chuta de volta para o login
if (!isset($_SESSION['pending_user_id'])) {
    header('Location: login.php');
    exit;
}

// Captura erros da sessão para exibir
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Unipet - Verificação de Segurança</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="shortcut icon" href="../assets/img/favicon/icon-unipet.png" type="image/png">

  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="../assets/css/modal.css">
  <link rel="stylesheet" href="../assets/css/menufixo.css">
  <link rel="stylesheet" href="../assets/css/footer.css">

  <script src="../assets/js/validacao.js" defer></script>
</head>

<body>
  <div id="toast" class="hidden"></div>
  
  <main>
    <div class="containermain container-background-image">
      <div class="containerform" id="form">
        
        <div class="containeresqueda">
          <div class="logoimglogin"> 
            <img src="../assets/img/fotoslogin/unipetdarkmode-removebg-preview.png" alt="Logo Unipet" id="logoimagemdarkmodee">
          </div>
          <div class="mensagemlogin">
            <p>Confirmação de <b style="color: #ff7b00;">Identidade</b></p>
            <p>Para sua segurança.</p>
          </div>
        </div>

        <?php if (!empty($errors)): ?>
            <div style="width: 100%; text-align: center; margin-bottom: 15px;">
                <?php foreach ($errors as $error): ?>
                    <p style="color: white; background-color: #ff4d4d; padding: 8px; border-radius: 5px; font-size: 0.9em;">
                        <?= htmlspecialchars($error) ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="../app/actions/validar_2fa.php" class="containerdireita">
          <div class="tiltelogin">
            <p><b>Pergunta de Segurança</b></p>
            <p style="font-size: 0.9rem; color: #666; margin-top: 5px;">Confirme seu CPF ou Nome Materno</p>
          </div>
          
          <div class="input-box">
            <input type="text" name="cpf_ou_nomeMaterno" placeholder="Digite a resposta aqui" id="cpf" required autocomplete="off">
          </div>
          
          <div class="btnentrar">
            <button type="submit" id="enviar">Validar Acesso</button>
          </div>
          
          <div class="voltaraohome" style="margin-top: 20px;">
            <a href="../app/includes/logout.php" style="color: #dc3545;">Cancelar / Sair</a>
          </div>
        </form>

      </div>
    </div>
  </main>

  <a id="link-topo" href="#">&#9650;</a>
</body>
</html>