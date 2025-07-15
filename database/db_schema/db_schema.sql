CREATE DATABASE IF NOT EXISTS buyathome;

CREATE TABLE IF NOT EXISTS produto(
    id_produto BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    preco_produto INT NOT NULL
)

CREATE TABLE IF NOT EXISTS promocao(
    id_promocao BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_produto BIGINT NOT NULL,
    id_usuario BIGINT NOT NULL,
    data_inicio BIGINT NOT NULL,
    data_fim BIGINT NOT NULL,
    percentual_desconto INT NOT NULL,
    foreign key fk_produto(id_produto) references produto(id_produto),
    foreign key fk_usuario(id_usuario) references usuario(id_usuario)
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

CREATE TABLE loja_produto IF NOT EXISTS loja_produto(
    id_loja_produto BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_loja BIGINT NOT NULL,
    id_produto BIGINT NOT NULL,
    quantidade INT NOT NULL,
    preco_produto INT NOT NULL,
    foreign key fk_loja(id_loja) references loja(id_loja),
    foreign key fk_produto(id_produto) references produto(id_produto),
    foreign key fk_preco(preco_produto) references produto(preco_produto)

)