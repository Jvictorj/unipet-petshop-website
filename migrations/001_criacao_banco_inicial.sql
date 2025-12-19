-- Arquivo: db_versions/001_criacao_banco_inicial.sql

-- 1. Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS unipet CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE unipet;

-- 2. Tabela de Usuários (Com suporte a 2FA e Níveis de Acesso)
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    sexo ENUM('masculino','feminino', 'outro') NOT NULL,
    nome_materno VARCHAR(100),
    cpf VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefone_celular VARCHAR(20),
    telefone_fixo VARCHAR(20),
    endereco_completo VARCHAR(255),
    login VARCHAR(50) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('cliente','admin','master') NOT NULL DEFAULT 'cliente',
    attempts INT NOT NULL DEFAULT 0,
    codigo_2fa VARCHAR(6) DEFAULT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao_curta TEXT,
    descricao_longa TEXT,
    preco DECIMAL(10, 2),
    imagem_principal VARCHAR(255),
    categoria VARCHAR(50),        
    spec_idade VARCHAR(50),        
    spec_linha VARCHAR(50),
    spec_pet VARCHAR(50),
    spec_porte VARCHAR(50),
    estoque INT DEFAULT 100
);

-- 4. Tabela de Favoritos
CREATE TABLE IF NOT EXISTS favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    produto_id INT NOT NULL,
    data_adicionado DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(usuario_id, produto_id), 
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- 5. Tabela de Logs do Sistema
CREATE TABLE IF NOT EXISTS logs_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    acao VARCHAR(50),
    descricao TEXT,
    ip_usuario VARCHAR(45),
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 6. Tabela de Mensagens de Contato
CREATE TABLE IF NOT EXISTS contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(150),
    mensagem TEXT,
    lida TINYINT(1) DEFAULT 0,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 7. Tabela de Pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    valor_total DECIMAL(10, 2),
    status ENUM('Pendente', 'Pago', 'Enviado', 'Entregue') DEFAULT 'Pendente',
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

-- =========================================================
-- DADOS INICIAIS (SEEDS)
-- =========================================================

-- Inserir Produtos de Exemplo
INSERT INTO produtos (nome, descricao_curta, descricao_longa, preco, imagem_principal, categoria, spec_idade, spec_linha, spec_pet, spec_porte)
VALUES 
(
    'Ração Golden Special Cães Adultos',
    'Ração Premium de ótima qualidade para nutrir seu cãozinho.',
    '- Indicada para cães adultos; <br> - Redução do odor das fezes; <br> - Blend de proteínas;',
    97.00,
    'cachorro/1.png', 
    'Cachorro',
    'Adulto',
    'Super Premium',
    'Cachorros',
    'Grande'
),
(
    'Ração Whiskas Gatos Castrados',
    'Sabor Carne, para gatos exigentes.',
    '- Controle de peso; <br> - Trato urinário saudável;',
    25.50,
    'gato/1.png', 
    'Gato',
    'Adulto',
    'Premium',
    'Gatos',
    'Todos'
),
(
    'Gaiola para Calopsita',
    'Espaço amplo para sua ave brincar.',
    '- Material resistente; <br> - Acompanha comedouro;',
    150.00,
    'aves/1.png', 
    'Aves',
    'Todas',
    'Standard',
    'Aves',
    'Médio'
);

-- Usuário Admin (Senha: 123)
-- OBS: Recomenda-se criar um novo via sistema para garantir que o hash funcione
INSERT INTO usuario (nome_completo, data_nascimento, sexo, nome_materno, cpf, email, telefone_celular, endereco_completo, login, senha_hash, nivel_acesso)
VALUES (
    'Administrador Master', 
    '1990-01-01', 
    'masculino', 
    'Mãe Admin', 
    '000.000.000-00', 
    'admin@unipet.com', 
    '21999999999', 
    'Rua do Admin, 1', 
    'admin', 
    '$2y$10$h/3lc.RGwVXoOFiL9bEutunHMLOnHcNdJV71AcyQeRZcWKUJJ4TbG', 
    'master'
);
