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

  // -- buscar por email para login
    public function buscarPorEmail(string $email): ?array
{
    $sql = "SELECT * FROM usuario WHERE email_usuario = :email LIMIT 1";
    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario ?: null;
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

    public function getPontosUser(int $idUser): ?int
  {
    $sql = "
      SELECT
        COALESCE(p.pontos_acumulados, 0) AS pontos
      FROM usuario u
      LEFT JOIN pontos_usuario p
        ON p.id_usuario = u.id_usuario
      WHERE u.id_usuario = :idUser
      LIMIT 1
    ";

    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);

    if (! $stmt->execute()) {
        return null;
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (! $row) {
        return 0;
    }

    return (int) $row['pontos'];
  }

  public function getValorPontosCupom(int $idCupom): ?int
    {
        $sql = "
            SELECT valor_pontos
            FROM cupom
            WHERE id_cupom = :idCupom
            LIMIT 1
        ";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':idCupom', $idCupom, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['valor_pontos'] : null;
    }

  public function atualizarPontosUsuario(int $idUser, int $novoSaldo): bool
    {
        $sql = "
            INSERT INTO pontos_usuario (id_usuario, pontos_acumulados)
            VALUES (:idUser, :pontos)
            ON DUPLICATE KEY
            UPDATE pontos_acumulados = :pontos
        ";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->bindValue(':pontos', $novoSaldo, PDO::PARAM_INT);
        return $stmt->execute();
    }

  public function salvarUsuarioCupom(int $idUser, int $idCupom): bool
    {
        $sql = "
            INSERT INTO usuario_cupom (id_usuario, id_cupom)
            VALUES (:idUser, :idCupom)
        ";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':idUser',  $idUser,  PDO::PARAM_INT);
        $stmt->bindValue(':idCupom', $idCupom, PDO::PARAM_INT);
        return $stmt->execute();
    }

  public function getConnection(): PDO
    {
        return $this->db->getConnection();
    }
}  
