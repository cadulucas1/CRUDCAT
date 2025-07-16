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
    
}  