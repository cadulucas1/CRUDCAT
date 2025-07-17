-- INSERT EXTREMAMENTE SIMPLES PARA TESTES, SERÁ ALTERADO POSTERIORMENTE 

-- Insert de usuário
INSERT INTO usuario (id_usuario, nome_usuario, email_usuario, senha_usuario, telefone_usuario)
VALUES
  (1, 'João Silva', 'joao.silva@example.com', '$2y$10$pYF7K2R9WWPMJqrfLbNaWuv6B6UCnjvYx0YyANPOBVzHAVnztzeGa', '67997866554');

-- Inserts de lojas
INSERT INTO loja (id_loja, nome_loja, num_endereco_loja, endereco_loja, horario_abertura, horario_fechamento)
VALUES
  (1, 'Mercado Central', 100, 'Rua das Flores', '08:00:00', '20:00:00'),
  (2, 'Padaria Pão Quente', 50, 'Av. Principal', '06:00:00', '18:00:00'),
  (3, 'Hortifruti Verde', 200, 'Rua do Campo', '07:00:00', '19:00:00');

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
  ('ADM', 'ADM@example.com', '$2y$10$pYF7K2R9WWPMJqrfLbNaWuv6B6UCnjvYx0YyANPOBVzHAVnztzeGa', '67999990000');


INSERT INTO promocao (id_produto, id_usuario, data_inicio, data_fim, percentual_desconto) VALUES
  (1, 2, '2025-07-16 00:00:00', '2025-07-23 23:59:59', 10),
  (3, 2, '2025-07-16 00:00:00', '2025-07-21 23:59:59', 15),
  (6, 2, '2025-07-18 00:00:00', '2025-07-25 23:59:59', 20);

-- 1. Insere 5 cupons para expirar em 2026
INSERT INTO cupom (
  codigo_cupom,
  descricao,
  valor_desconto,
  valor_pontos,
  data_expiracao
)
VALUES
  ('PROMO2026A', 'Desconto de boas‑vindas 2026',   5.00,  500, '2026-12-31'),
  ('PROMO2026B', 'Promoção verão 2026',            10.00, 250, '2026-06-30'),
  ('PROMO2026C', 'Oferta especial 2026',           15.00, 600, '2026-09-30'),
  ('PROMO2026D', 'Desconto fidelidade 2026',       20.00, 100, '2026-11-30'),
  ('PROMO2026E', 'Cupom festa de fim de ano 2026', 25.00, 750, '2026-12-15');

-- 2. Atribui 500 pontos ao usuário de id 1
INSERT INTO pontos_usuario (id_usuario, pontos_acumulados)
VALUES (1, 500);
-- Caso já exista um registro e você queira somar 500 pontos, use:
-- ON DUPLICATE KEY UPDATE pontos_acumulados = pontos_acumulados + 500; :contentReference[oaicite:1]{index=1}

-- 1. Insere um novo cupom
INSERT INTO cupom (
  codigo_cupom,
  descricao,
  valor_desconto,
  valor_pontos,
  data_expiracao
)
VALUES
  (
    'PROMO2026F', 
    'Desconto relâmpago 2026', 
    30.00,        -- 30% de desconto
    300,          -- custa 300 pontos
    '2026-10-31'
  );

-- 2. Marca que o usuário 1 já resgatou esse cupom
INSERT INTO usuario_cupom (
  id_usuario,
  id_cupom
)
VALUES
  (
    1,
    LAST_INSERT_ID()  -- usa o ID gerado pelo INSERT anterior
  );
