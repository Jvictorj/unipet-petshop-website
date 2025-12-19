# 🚀 Roadmap de Atualizações e Correções (UPDATE.md)

Este documento rastreia as tarefas necessárias para estabilizar o sistema após a grande refatoração de pastas (MVC) e lista melhorias futuras.

---

## 🚨 Prioridade Alta: Correção de Caminhos (Pós-Refatoração)
*Tarefas obrigatórias para que o site volte a funcionar nas novas pastas.*

### 1. Atualizar Includes do PHP (`require_once`)
Os arquivos movidos para subpastas agora precisam subir **dois níveis** (`../../`) para achar a pasta `app`.

- [ ] **Auth (`public/auth/`):**
    - [ ] `login.php`
    - [ ] `register.php`
    - [ ] `esqueciasenha.php`
    - [ ] `atualizar-senha.php`
    - [ ] `2fa.php`
- [ ] **Admin (`public/admin/`):**
    - [ ] `admin-produtos.php`
    - [ ] `admin-produto-form.php`
    - [ ] `admin-pedidos.php`
    - [ ] `master-usuarios.php`
    - [ ] `relatorios.php`
- [ ] **Cliente (`public/cliente/`):**
    - [ ] `painel.php`
    - [ ] `meus-pedidos.php`
    - [ ] `dados-pessoais.php`
    - [ ] `carrinho.php`

### 2. Atualizar Links de Formulários (`action="..."`)
Os formulários HTML ainda apontam para os caminhos antigos.
*Exemplo:* De `action="../app/acao/login.php"` para `action="../../app/actions/auth/login.php"`.

- [ ] Corrigir form no `login.php`
- [ ] Corrigir form no `register.php`
- [ ] Corrigir form no `admin-produto-form.php` (Salvar produto)
- [ ] Corrigir links de "Excluir" e "Adicionar ao Carrinho"

### 3. Atualizar Links de CSS e JS
Garantir que a variável `$path` esteja sendo usada ou que os caminhos fixos estejam corretos.

- [ ] Verificar se o `header.php` está carregando o CSS corretamente em todas as subpastas.
- [ ] Verificar se as imagens (`<img src="...">`) dentro da pasta `admin` e `cliente` estão carregando.

---

## 🧹 Melhorias de Código (Refactor)

- [ ] **Padronizar nome da pasta de ações:**
    - Atualmente existem referências a `app/acao` e `app/actions`.
    - **Meta:** Mover tudo para `app/actions` e atualizar os links.
- [ ] **Remover CSS inline:**
    - Identificar arquivos PHP que ainda têm `<style>` ou `style="..."` e mover para os arquivos `.css` correspondentes em `assets/css`.
- [ ] **Limpeza de Imagens:**
    - Organizar a pasta `assets/img` removendo duplicatas ou imagens de teste que não são usadas no layout final.

---

## ✨ Funcionalidades Futuras (Backlog)

### Funcionalidades
- [ ] **Upload de Imagens Real:** Fazer o formulário de produtos salvar a imagem na pasta `assets/img/uploads` e gravar apenas o nome no banco.
- [ ] **Sistema de Pagamento:** Integrar com uma API real (Mercado Pago ou Stripe) no lugar do botão "Finalizar Compra" atual.
- [ ] **Recuperação de Senha Real:** Implementar o envio de e-mail com PHPMailer na lógica de `esqueciasenha.php`.

### Segurança
- [ ] **Proteger Uploads:** Validar se o arquivo enviado é realmente uma imagem (JPG/PNG).
- [ ] **Sessão:** Implementar timeout de sessão (deslogar automaticamente após 30min de inatividade).

---

## 📝 Histórico de Atualizações Recentes

- **[DATA ATUAL]** - 🏗️ **Refactor:** Reestruturação completa do projeto para padrão MVC. Separação de pastas em `app` (backend), `public` (frontend) e `assets` (estáticos). Criação de branch `refactor/nova-estrutura`.