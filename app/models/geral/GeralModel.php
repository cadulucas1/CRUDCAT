<?php
require_once __DIR__ . '/../connect.php';

class GeralModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function getLojaProdutoByIdComSeguimento(int $idUser, int $idLoja) {
        $sql = "
        SELECT
        l.id_loja,
        l.nome_loja,
        l.num_endereco_loja,
        l.endereco_loja,
        l.horario_abertura,
        l.horario_fechamento,
        COALESCE(ls.status_seguida, 0) AS seguindo,
        p.id_produto,
        p.nome_produto,
        lp.preco_produto AS preco_original,
        MAX(pr.percentual_desconto) AS percentual_desconto,
        -- calcula o preço com o maior desconto encontrado (0 se não houver)
        ROUND(
          lp.preco_produto * 
          (1 - COALESCE(MAX(pr.percentual_desconto), 0) / 100)
        , 2) AS preco_venda_loja,
        lp.quantidade
      FROM loja l
      LEFT JOIN loja_produto lp
        ON lp.id_loja = l.id_loja
      LEFT JOIN produto p
        ON p.id_produto = lp.id_produto
      LEFT JOIN lojas_seguidas ls
        ON ls.id_loja    = l.id_loja
       AND ls.id_usuario = :idUser
      LEFT JOIN promocao pr
        ON pr.id_produto = p.id_produto
       AND NOW() BETWEEN pr.data_inicio AND pr.data_fim
      WHERE l.id_loja = :idLoja
      GROUP BY
        l.id_loja,
        l.nome_loja,
        l.num_endereco_loja,
        l.endereco_loja,
        l.horario_abertura,
        l.horario_fechamento,
        ls.status_seguida,
        p.id_produto,
        p.nome_produto,
        lp.preco_produto,
        lp.quantidade;";
    
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':idUser',  $idUser,  PDO::PARAM_INT);
        $stmt->bindValue(':idLoja',  $idLoja,  PDO::PARAM_INT);
        $stmt->execute();
    
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$rows) {
            return null;
        }
    
        $first = $rows[0];
        $loja = [
            'id_loja'           => (int)$first['id_loja'],
            'nome_loja'         => $first['nome_loja'],
            'num_endereco_loja' => (int)$first['num_endereco_loja'],
            'endereco_loja'     => $first['endereco_loja'],
            'horario_abertura'  => $first['horario_abertura'],
            'horario_fechamento'=> $first['horario_fechamento'],
            'seguindo'          => (bool)$first['seguindo'],
            'produtos'          => []
        ];
    
        foreach ($rows as $r) {
            if ($r['id_produto'] === null) {
                continue;
            }
    
            $loja['produtos'][] = [
                'id_produto'         => (int)   $r['id_produto'],
                'nome_produto'       =>         $r['nome_produto'],
                'preco_original'     => (float) $r['preco_original'],
                'preco_venda_loja'   => (float) $r['preco_venda_loja'],
                'quantidade'         => (int)   $r['quantidade'],
                'percentual_desconto'=> $r['percentual_desconto'] !== null
                                          ? (int)$r['percentual_desconto']
                                          : 0
            ];
        }
    
        return $loja;
    }

  public function getCuponsDisponiveis(int $idUser): array|null
  {
    $sql = "
    SELECT
      c.id_cupom,
      c.codigo_cupom,
      c.descricao,
      c.valor_desconto,
      c.data_expiracao,
      c.valor_pontos,
      -- se o join encontrar registro, o usuário já tem o cupom
      CASE WHEN uc.id_usuario IS NOT NULL THEN 1 ELSE 0 END AS adquirido
    FROM cupom c
    LEFT JOIN usuario_cupom uc
      ON uc.id_cupom = c.id_cupom
     AND uc.id_usuario = :idUser
    WHERE
      c.status_ativo = TRUE
      AND c.data_expiracao >= CURDATE()
    ORDER BY c.data_expiracao ASC;
    ";

    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
        return null;
    }

    return array_map(function($r) {
        return [
            'id_cupom'      => (int)   $r['id_cupom'],
            'codigo_cupom'  =>         $r['codigo_cupom'],
            'valor_pontos'  => (int)   $r['valor_pontos'],
            'descricao'     =>         $r['descricao'],
            'valor_desconto'=> (float) $r['valor_desconto'],
            'data_expiracao'=>         $r['data_expiracao'],
            'adquirido'     => (bool)  $r['adquirido'],
        ];
    }, $rows);
  }

  public function buscarLojasPorNomeOuEndereco(string $termo): array {
    $sql = "
        SELECT 
            id_loja,
            nome_loja,
            endereco_loja,
            num_endereco_loja,
            horario_abertura,
            horario_fechamento
        FROM loja
        WHERE 
            nome_loja COLLATE utf8mb4_general_ci LIKE :termo OR
            endereco_loja COLLATE utf8mb4_general_ci LIKE :termo OR
            CONCAT(num_endereco_loja, ' ', endereco_loja) COLLATE utf8mb4_general_ci LIKE :termo
        LIMIT 20
    ";

      $stmt = $this->db->getConnection()->prepare($sql);
      $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
      $stmt->execute();

      $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // Calcular status "Aberto" ou "Fechado"
      $agora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
      foreach ($dados as &$loja) {
          $abertura = DateTime::createFromFormat('H:i:s', $loja['horario_abertura']);
          $fechamento = DateTime::createFromFormat('H:i:s', $loja['horario_fechamento']);

          if ($abertura && $fechamento && $agora >= $abertura && $agora <= $fechamento) {
              $loja['status'] = 'Aberto';
          } else {
              $loja['status'] = 'Fechado';
          }
      }

      return $dados;
  }

  public function getAllLojas(): array {
    $sql = "
        SELECT 
            id_loja,
            nome_loja,
            endereco_loja,
            num_endereco_loja,
            horario_abertura,
            horario_fechamento
        FROM loja
        LIMIT 50
    ";

    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->execute();

    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular status "Aberto" ou "Fechado"
    $agora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

    foreach ($dados as &$loja) {
        $abertura = DateTime::createFromFormat('H:i:s', $loja['horario_abertura']);
        $fechamento = DateTime::createFromFormat('H:i:s', $loja['horario_fechamento']);

        if ($abertura && $fechamento && $agora >= $abertura && $agora <= $fechamento) {
            $loja['status'] = 'Aberto';
        } else {
            $loja['status'] = 'Fechado';
        }
    }

    return $dados;
  }


}  