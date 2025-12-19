<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

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

  <title>Unipet - Crie sua conta</title>
  <meta name="description" content="Cadastre-se na Unipet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="shortcut icon" href="../assets/img/favicon/icon-unipet.png" type="image/png">

  <link rel="stylesheet" href="../assets/css/register.css">
  <link rel="stylesheet" href="../assets/css/modal.css">
  <link rel="stylesheet" href="../assets/css/menufixo.css">
  <link rel="stylesheet" href="../assets/css/footer.css">

  <script src="../assets/js/validacao.js" defer></script>
</head>

<body>
<main>
  <div id="toast" class="hidden"></div>
  <div id="toast2" class="hidden"></div>

  <div class="containermain container-background-image">
    <div class="containerform">
      <div class="containertop">
        <div class="logoimglogin"> 
          <a href="index.php">
            <img src="../assets/img/fotoslogin/unipetdarkmode-removebg-preview.png" alt="Logo" id="logoimagemdarkmodee">
          </a>
        </div>
        <div class="mensagemlogin">
          <p>Criar uma <b style="color: #ff7b00;">nova conta</b></p>
          <p>Primeira <b style="color: #ff7b00;">etapa</b></p>
          
          <div class="progressbar">
            <ul>
              <li class="active form_1_progessbar"><div><p class="p1">1</p></div></li>
              <li class="form_2_progessbar"><div><p class="p2">2</p></div></li>
            </ul>
          </div>
        </div>
      </div>

      <?php
      if (!empty($_SESSION['errors'])) {
          echo "<div style='background-color: #ffcccc; color: #cc0000; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: center;'>";
          foreach ($_SESSION['errors'] as $error) {
              echo "<p>" . htmlspecialchars($error) . "</p>";
          }
          echo "</div>";
          unset($_SESSION['errors']); // Limpa os erros após exibir
      }
      ?>

      <form method="post" action="../app/actions/cadastro.php" class="containerdireita" id="form">
        
        <div class="input-box">
          <input type="text" name="nome" placeholder="Nome Completo" id="nome" required>
        </div>
        
        <div class="input-box">
          <input type="date" name="data_nascimento" id="data" required>
        </div>
        
        <div class="input-boxsex">
          <label for="sexo">Sexo</label>
          <select name="sexo" id="sexo">
            <option value="" selected>--- Escolha ---</option>
            <option value="masc">Masculino</option>
            <option value="femi">Feminino</option>
            <option value="naosei">Prefiro não dizer</option>
          </select>
        </div>
        
        <div class="input-box">
          <input type="text" name="nomemae" placeholder="Nome Materno" id="nomemae" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="cpf" placeholder="CPF" id="cpf" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="cell" placeholder="Telefone Celular" id="telefonecelular" required>
        </div>    
        
        <div class="input-box">
          <input type="email" name="email" placeholder="E-mail" id="email" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="login" placeholder="Login" id="login" required>
        </div>              
        
        <div class="input-box">
          <input type="password" name="senha" placeholder="Senha" id="senha" required>
        </div>
        
        <div class="input-box">
          <input type="password" name="confsenha" placeholder="Confirme sua senha" id="confsenha" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="cep" placeholder="CEP" id="cep" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="bairro" placeholder="Digite o nome do seu Bairro" id="bairro" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="cidade" placeholder="Digite sua Cidade" id="cidade" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="estado" placeholder="Digite seu Estado" id="estado" required>
        </div>
        
        <div class="input-box">
          <input type="text" name="tellfixo" placeholder="Telefone Fixo" id="fixo" required>
        </div>    
        
        <div class="btncadastrar">
          <button type="submit" id="enviar">Cadastrar</button>
          <button type="button" id="limpar" onclick="resetartext()">Limpar</button>
        </div>

        <div class="voltaraohome">
          <p>Já possui uma conta?</p>
          <a href="login.php">Clique aqui para fazer login.</a>
        </div>
      </form>
    </div>
  </div>
</main>
</body>
</html>