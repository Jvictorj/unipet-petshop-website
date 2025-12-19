# 🛠️ Correção de Caminhos - [Pendente]

Ao criar ou mover arquivos PHP, a maior causa de erros é o **caminho dos arquivos** (`require` ou `href`). Embora isso ainda não tenha sido corrigido, você pode usar este guia para não errar no futuro.

Este arquivo serve como **referência temporária** até que os erros de caminhos sejam corrigidos.

## 1. Regra dos Níveis (`../` vs `../../`)

Sempre conte quantas pastas você precisa "voltar" para chegar na raiz do projeto.

### **Arquivos na Raiz da Public** (`public/index.php`):

* Para acessar `app`: `../app/...`
* Para acessar `assets`: `../assets/...`

### **Arquivos em Subpastas** (`public/admin/painel.php` ou `public/auth/login.php`):

* **REGRA DE OURO**: Você desceu um nível, então precisa subir dois.
* Para acessar `app`: `../../app/...`
* Para acessar `assets`: `../../assets/...`

## 2. Como fazer Includes no PHP

### **Exemplo Errado** (Vai quebrar em subpastas):

```php
require_once 'header.php'; // Erro
require_once '../app/includes/header.php'; // Só funciona na raiz public/
```

### **Exemplo Correto** (Dentro de `public/admin/`):

```php
// Sobe dois níveis para achar a pasta app
require_once '../../app/includes/conexao.php';
require_once '../../app/includes/functions.php';
```

## 3. Como funciona o CSS e JS (`$path`)

Para evitar que o CSS quebre, o arquivo `app/includes/header.php` foi programado para detectar onde ele está.

### **Exemplo para Subpastas**:

Se você criar uma página nova em uma subpasta (ex: `public/financeiro/relatorio.php`), defina a variável `$path` antes de incluir o header para garantir que o CSS funcione corretamente:

```php
<?php
// Define que estamos 2 níveis abaixo da raiz
$path = '../../'; 

require_once '../../app/includes/header.php';
?>
```

## 4. Links HTML (Imagens e Links)

Nunca use caminhos absolutos do seu PC (ex: `C:/xampp...`). Use caminhos relativos baseados na regra dos níveis.

### **Link para Home**:

* De `admin/painel.php` para Home:

  ```html
  <a href="../index.php">Ir para Loja</a>
  ```

### **Imagem**:

* De `cliente/pedidos.php`:

  ```html
  <img src="../../assets/img/logo.png">
  ```

---

## ⚠️ Importante

Essas correções são **pendentes** e devem ser feitas conforme a necessidade. A ideia é revisar os caminhos e garantir que tudo funcione corretamente após as mudanças na estrutura do projeto.

### **Nota sobre o Fluxo**:

* Quando você for corrigir essas questões de caminhos, lembre-se de que não basta apenas corrigir os arquivos PHP. As rotas de links, imagens e outros recursos também precisam ser revisadas.
* A correção desses erros de caminho pode afetar várias partes do sistema, então faça com cuidado e sempre revise os arquivos afetados.