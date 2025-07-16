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


  public function existeEmail(string $email): bool {
    $sql = "SELECT COUNT(*) FROM usuario WHERE email_usuario = :email";
    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }

  public function existeTelefone(string $telefone): bool {
      $sql = "SELECT COUNT(*) FROM usuario WHERE telefone_usuario = :telefone";
      $stmt = $this->db->getConnection()->prepare($sql);
      $stmt->bindValue(':telefone', $telefone);
      $stmt->execute();
      return $stmt->fetchColumn() > 0;
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
        AND 
          ls.status_seguida = TRUE
    ";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

  public function cadastrar(string $nome, string $email, string $telefone, string $senha): bool
    {
        $sql = "INSERT INTO usuario
                   (nome_usuario, email_usuario, telefone_usuario, senha_usuario)
                VALUES
                   (:nome, :email, :telefone, :senha)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':nome',     $nome,     PDO::PARAM_STR);
        $stmt->bindValue(':email',    $email,    PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bindValue(':senha',    $hash,     PDO::PARAM_STR);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                return false;
            }
            throw $e;
        }
    }


}  
