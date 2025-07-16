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
    ";

    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
    $stmt->execute();

    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return empty($dados) ? null : $dados;
  }

}  