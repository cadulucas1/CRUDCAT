CREATE DATABASE IF NOT EXISTS buyathome;
USE buyathome;

-- Usuário
CREATE TABLE IF NOT EXISTS usuario (
    id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(255) NOT NULL,
    email_usuario VARCHAR(255) UNIQUE NOT NULL,
    senha_usuario VARCHAR(255) NOT NULL,
    telefone_usuario VARCHAR(20) UNIQUE NOT NULL
);

-- Produto
CREATE TABLE IF NOT EXISTS produto (
    id_produto BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    preco_produto DECIMAL(10,2) NOT NULL
);

-- Loja
CREATE TABLE IF NOT EXISTS loja (
    id_loja BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_loja VARCHAR(255) NOT NULL,
    num_endereco_loja INT NOT NULL,
    endereco_loja VARCHAR(255) NOT NULL,
    horario_abertura TIME,
    horario_fechamento TIME
);

-- Promoção
CREATE TABLE IF NOT EXISTS promocao (
    id_promocao BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_produto BIGINT NOT NULL,
    id_usuario BIGINT NOT NULL,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NOT NULL,
    percentual_desconto INT NOT NULL,
    CONSTRAINT fk_promocao_produto
    FOREIGN KEY (id_produto) REFERENCES produto(id_produto),
    CONSTRAINT fk_promocao_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

-- Associação Loja - Produto
CREATE TABLE IF NOT EXISTS loja_produto (
    id_loja_produto BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_loja BIGINT NOT NULL,
    id_produto BIGINT NOT NULL,
    quantidade INT NOT NULL,
    preco_produto DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_lp_loja
    FOREIGN KEY (id_loja) REFERENCES loja(id_loja),
    CONSTRAINT fk_lp_produto
    FOREIGN KEY (id_produto) REFERENCES produto(id_produto)
);

-- Lojas seguidas pelo cliente
CREATE TABLE IF NOT EXISTS lojas_seguidas (
  id_loja_seguida BIGINT AUTO_INCREMENT PRIMARY KEY,
  id_usuario BIGINT NOT NULL,
  id_loja BIGINT NOT NULL,
  status_seguida BOOLEAN NOT NULL,
  CONSTRAINT fk_ls_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
  CONSTRAINT fk_ls_loja FOREIGN KEY (id_loja) REFERENCES loja(id_loja)
);


CREATE TABLE suporte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assunto VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
    
);