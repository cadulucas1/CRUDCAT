-- INSERT EXTREMAMENTE SIMPLES PARA TESTES, SERÁ ALTERADO POSTERIORMENTE 

-- Insert de usuário
INSERT INTO usuario (id_usuario, nome_usuario, email_usuario, senha_usuario, telefone_usuario)
VALUES
  (1, 'João Silva', 'joao.silva@example.com', 'senhaSegura123', '67997866554');

-- Inserts de lojas
INSERT INTO loja (id_loja, nome_loja, num_endereco_loja, endereco_loja, horario_abertura, horario_fechamento)
VALUES
  (1, 'Mercado Central', 100, 'Rua das Flores, 100', '08:00:00', '20:00:00'),
  (2, 'Padaria Pão Quente', 50, 'Av. Principal, 50', '06:00:00', '18:00:00'),
  (3, 'Hortifruti Verde', 200, 'Rua do Campo, 200', '07:00:00', '19:00:00');

-- Inserts de lojas seguidas pelo usuário
INSERT INTO lojas_seguidas (id_loja_seguida, id_usuario, id_loja, status_seguida)
VALUES
  (1, 1, 1, TRUE),
  (2, 1, 2, TRUE),
  (3, 1, 3, TRUE);

INSERT INTO produto (nome_produto, preco_produto) VALUES
  ('Arroz Tipo 1', 10.50),
  ('Feijão Carioca', 8.25),
  ('Óleo de Soja', 5.90),
  ('Macarrão Espaguete', 4.20),
  ('Açúcar Cristal', 3.80),
  ('Café Torrado', 12.00);

INSERT INTO loja_produto (id_loja, id_produto, quantidade, preco_produto) VALUES
  (1, 1, 50, 10.50),
  (1, 2, 40, 8.25),
  (1, 3, 60, 5.90),
  (1, 4, 30, 4.20),
  (1, 5, 20, 3.80),
  (1, 6, 25, 12.00);

INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, telefone_usuario) VALUES
  ('ADM', 'ADM@example.com', 'senha123', '67999990000');


INSERT INTO promocao (id_produto, id_usuario, data_inicio, data_fim, percentual_desconto) VALUES
  (1, 2, '2025-07-16 00:00:00', '2025-07-23 23:59:59', 10),
  (3, 2, '2025-07-16 00:00:00', '2025-07-21 23:59:59', 15),
  (6, 2, '2025-07-18 00:00:00', '2025-07-25 23:59:59', 20);
