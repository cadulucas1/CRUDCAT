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


CREATE TABLE IF NOT EXISTS suporte (
    id_suporte INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT NOT NULL,
    assunto VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_suporte_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

-- Tabela de Cupons
CREATE TABLE IF NOT EXISTS cupom (
    id_cupom BIGINT AUTO_INCREMENT PRIMARY KEY,
    codigo_cupom VARCHAR(50) NOT NULL UNIQUE,
    valor_pontos INT NOT NULL DEFAULT 0,
    descricao VARCHAR(255) NOT NULL,                         
    valor_desconto DECIMAL(10,2) NOT NULL,                  
    data_expiracao DATE NOT NULL,                            
    status_ativo BOOLEAN NOT NULL DEFAULT TRUE,              
    data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE IF NOT EXISTS usuario_cupom (
  id_usuario BIGINT NOT NULL,
  id_cupom   BIGINT NOT NULL,
  data_aquisicao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_usuario, id_cupom),
  CONSTRAINT fk_uc_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
  CONSTRAINT fk_uc_cupom    FOREIGN KEY (id_cupom)   REFERENCES cupom(id_cupom)
);

-- Tabela de Pontos por Usuário
CREATE TABLE IF NOT EXISTS pontos_usuario (
    id_pontos BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT NOT NULL UNIQUE,
    pontos_acumulados INT NOT NULL DEFAULT 0, 
    data_atualizacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pontos_usuario
      FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

-- Tabela de tarefas
CREATE TABLE IF NOT EXISTS tarefas (
    id_tarefa BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_tarefa VARCHAR(255),
    descricao VARCHAR(255),
    pontos_tarefa BIGINT
);

-- Tabela de tarefas por usuário com FKs
CREATE TABLE IF NOT EXISTS tarefa_usuario (
    id_tarefa_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_tarefa BIGINT NOT NULL,
    id_cliente BIGINT NOT NULL,
    status_tarefa BOOLEAN,
    CONSTRAINT fk_tarefa_usuario_tarefa FOREIGN KEY (id_tarefa) REFERENCES tarefas(id_tarefa),
    CONSTRAINT fk_tarefa_usuario_cliente FOREIGN KEY (id_cliente) REFERENCES usuario(id_usuario)
);


ALTER TABLE loja CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
