<?php
// Regra 2: Iniciar sessão
session_start();

// Regra 1: Includes com caminho relativo correto
require_once '../app/includes/functions.php';

// OPCIONAL: Se você quiser que APENAS usuários logados enviem mensagem, descomente a linha abaixo:
// ensureUser(); 

// Configuração da Página
$pageTitle = "Unipet - Fale Conosco";

// CSS Específico desta página (O header já carrega o footer.css, menufixo.css e modal.css)
$pageCss = ['../assets/css/contato.css'];

// Inclusão do Cabeçalho
require_once '../app/includes/header.php';
?>

<body>
    <section class="form-container">
        <div class="container">
            <form method="post" action="../app/acao/envia.php">
                <h1>Entre em contato </h1>
                <p> Preencha o formulário abaixo e entraremos em contato com você.</p>
                
                <div class="input-single">
                    <input class="input" type="text" id="nome" name="nome" required autocomplete="off">
                    <label for="nome">Seu nome completo</label>
                </div>
                
                <div class="input-single">
                    <input class="input" type="email" id="email" name="email" required autocomplete="off">
                    <label for="email">Seu e-mail</label>
                </div>
                
                <div class="input-single">
                    <input class="input" type="tel" id="telefone" name="telefone" required autocomplete="off">
                    <label for="telefone"> Seu telefone</label>
                </div>
                
                <div class="input-mensagem">
                    <textarea placeholder="Digite aqui sua Mensagem (opcional)" name="mensagem" cols="30" rows="10" style="width: 100%; padding: 10px; border-radius: 15px; border: 1px solid #ccc; outline: none;"></textarea>
                </div>
                
                <div class="btn"><input type="submit" value="Enviar"></div>
            </form>
        </div>
    </section>

<?php
// Inclusão do Rodapé
require_once '../app/includes/footer.php';
?>