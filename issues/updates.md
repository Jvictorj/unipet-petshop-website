# 🚀 Roadmap de Atualizações e Correções (UPDATE.md)

Este documento acompanha as **tarefas necessárias para estabilizar o sistema** após a grande refatoração para o padrão **MVC**, além de listar **melhorias futuras e backlog**.

---

## 🚨 Prioridade Alta — Correção de Caminhos (Pós-Refatoração)

> Tarefas **obrigatórias** para que o sistema volte a funcionar corretamente após a mudança de estrutura de pastas.

---

## 🛒 Prioridade Atual — Finalização do Fluxo de Compra

> Transformar o carrinho em um **pedido real salvo no banco de dados**.

### 1️⃣ Estrutura do Banco de Dados

* [ ] Criar tabela `pedidos`

  * `id`, `usuario_id`, `total`, `status`, `data`, `metodo_pagamento`
* [ ] Criar tabela `itens_pedido`

  * `id`, `pedido_id`, `produto_id`, `quantidade`, `preco_unitario`

---

### 2️⃣ Página de Checkout (`public/checkout.php`)

* [ ] Confirmação de endereço
* [ ] Resumo final (produtos + frete fictício)
* [ ] Botão **Confirmar Pedido**

---

### 3️⃣ Processamento do Pedido

`app/actions/shop/finalizar_pedido.php`

* [ ] Salvar pedido na tabela `pedidos`
* [ ] Salvar itens do carrinho em `itens_pedido`
* [ ] Limpar `$_SESSION['carrinho']` após sucesso

---

## 🛠️ Melhorias Administrativas (Admin & Master)

* [ ] **Dashboard com Gráficos**

  * Implementar Chart.js no `public/admin/painel.php`
  * Pedidos do dia, faturamento e produtos mais vendidos

* [ ] **Gestão de Estoque**

  * Adicionar campo `estoque` na tabela `produtos`
  * Bloquear compra quando estoque for zero

* [ ] **Upload de Imagens**

  * Salvar arquivos em `assets/img/produtos`
  * Gravar apenas o nome no banco

---

## ✨ Experiência do Usuário (Backlog)

* [ ] Filtros avançados (preço, marca, categoria)
* [ ] Sistema de avaliação (estrelas + comentários)
* [ ] E-mails automáticos de pedido (PHPMailer)
* [ ] Recuperação de senha real por e-mail
* [ ] Adicionar CEP API
* [ ] CPF Validator
* [ ] nome do usario aparece quando logado no dashboard e outros lugares necessarios
* [ ] melhora o css do error de validação em login, esqueci senha e cadastro

---

## 🔒 Segurança

* [ ] Validar upload de imagens (JPG/PNG)
* [ ] Timeout de sessão (30 minutos)
* [ ] Proteção contra compras sem estoque

---

## ✅ Concluído — Fase de Estabilização

* [x] Refatoração completa para padrão MVC
* [x] Padronização de caminhos com variável `$path`
* [x] Home pública (`index.php`)
* [x] Organização das actions (`auth` e `shop`)
* [x] Carrinho com AJAX (quantidade dinâmica)
* [x] Segurança Master (logs e cargos)

---

## 📝 Histórico de Versões

* **v1.1.0** — Refatoração MVC, organização de pastas e caminhos dinâmicos
* **v1.0.0** — Lançamento inicial (login, cadastro e vitrine)

---

## 📝 Atualizações Recentes

* **[DATA ATUAL]** 🏗️ **Refactor**

  * Reestruturação completa do projeto
  * Separação em `app`, `public` e `assets`
  * Criação da branch `refactor/nova-estrutura`



