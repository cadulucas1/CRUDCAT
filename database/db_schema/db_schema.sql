CREATE DATABASE IF NOT EXISTS buyathome;

CREATE TABLE IF NOT EXISTS produto(
    id_produto BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    preco_produto INT NOT NULL
)

CREATE TABLE IF NOT EXISTS promocao(
    id_promocao BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_produto BIGINT NOT NULL,
    foreign key fk_produto(id_produto) references produto(id_produto)
)

CREATE TABLE IF NOT EXISTS usuario(
    id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(255) NOT NULL,
    email_usuario VARCHAR(255) UNIQUE NOT NULL,
    senha_usuario VARCHAR(255) NOT NULL,
    telefone_usuario INT UNIQUE NOT NULL
)

CREATE TABLE IF NOT EXISTS loja(
    id_loja BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_loja VARCHAR(255) NOT NULL,
    num_endereco_loja INT NOT NULL,
    endereco_loja VARCHAR(255) NOT NULL,
    horario_abertura TIME,
    horario_fechamento TIME
)