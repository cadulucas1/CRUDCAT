<?php
require_once __DIR__ . '/../connect.php';

class ClienteModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

<<<<<<< HEAD
    public function getLojasById($idUser)
    {
        $sql = "
            SELECT 
              ls.id_usuario,
              ls.id_loja,
              ls.status_seguida,
              l.id_loja AS loja_id,
              l.nome_loja,
              l.num_endereco_loja,
              l.endereco_loja,
              l.horario_abertura,
              l.horario_fechamento
            FROM 
              lojas_seguidas AS ls
              INNER JOIN loja AS l ON ls.id_loja = l.id_loja
            WHERE 
              ls.id_usuario = :idUser
        ";
=======
  public function getLojasById($idUser) {
    $sql = "
        SELECT 
          ls.id_usuario,
          ls.id_loja,
          ls.status_seguida,
          l.id_loja AS loja_id,
          l.nome_loja,
          l.num_endereco_loja,
          l.endereco_loja,
          l.horario_abertura,
          l.horario_fechamento
        FROM 
          lojas_seguidas AS ls
          INNER JOIN loja AS l
            ON ls.id_loja = l.id_loja
        WHERE 
          ls.id_usuario = :idUser
        AND 
          ls.status_seguida = TRUE
    ";
>>>>>>> 2145986e15976884e899625f17f0de21575b3280

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

<<<<<<< HEAD
        return empty($dados) ? null : $dados;
    }
}
=======
    return empty($dados) ? null : $dados;
  }

  public function toggleSeguirLoja(int $idUser, int $idLoja, bool $seguir): bool {
    $sql = $seguir
      ? "INSERT INTO lojas_seguidas (id_usuario, id_loja, status_seguida)
         VALUES (:u, :l, true)
         ON DUPLICATE KEY UPDATE status_seguida = true"
      : "UPDATE lojas_seguidas
         SET status_seguida = false
         WHERE id_usuario = :u AND id_loja = :l";
  
    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->bindValue(':u', $idUser, PDO::PARAM_INT);
    $stmt->bindValue(':l', $idLoja, PDO::PARAM_INT);
    return $stmt->execute();
  }

}  
>>>>>>> 2145986e15976884e899625f17f0de21575b3280
