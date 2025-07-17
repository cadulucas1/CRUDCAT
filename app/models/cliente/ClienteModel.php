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

  public function listarTarefasComStatus(int $idUsuario): array {
    $sql = "
        SELECT 
            t.id_tarefa,
            t.nome_tarefa,
            t.descricao,
            t.pontos_tarefa,
            tu.status_tarefa,
            CASE 
                WHEN tu.status_tarefa = TRUE THEN 'Concluída'
                WHEN tu.status_tarefa = FALSE THEN 'Pendente'
                ELSE 'Não iniciada'
            END AS situacao
        FROM tarefas t
        LEFT JOIN tarefa_usuario tu 
            ON t.id_tarefa = tu.id_tarefa 
            AND tu.id_cliente = :idUsuario
    ";

    $stmt = $this->db->getConnection()->prepare($sql);
    $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getConnection(): PDO
    {
        return $this->db->getConnection();
    }

  public function marcarTarefaComoRealizada(int $idUsuario, int $idTarefa): bool {
    $conn = $this->db->getConnection();

    try {
        $conn->beginTransaction();

        // Verifica se a tarefa já está marcada
        $sqlVerifica = "
            SELECT COUNT(*) FROM tarefa_usuario 
            WHERE id_cliente = :idUsuario AND id_tarefa = :idTarefa
        ";

        $stmt = $conn->prepare($sqlVerifica);
        $stmt->execute([
            ':idUsuario' => $idUsuario,
            ':idTarefa' => $idTarefa
        ]);

        $existe = $stmt->fetchColumn() > 0;

        if ($existe) {
            // Atualiza status caso já exista
            $sqlUpdate = "
                UPDATE tarefa_usuario 
                SET status_tarefa = TRUE 
                WHERE id_cliente = :idUsuario AND id_tarefa = :idTarefa
            ";
            $stmt = $conn->prepare($sqlUpdate);
        } else {
            // Insere novo registro
            $sqlInsert = "
                INSERT INTO tarefa_usuario (id_tarefa, id_cliente, status_tarefa)
                VALUES (:idTarefa, :idUsuario, TRUE)
            ";
            $stmt = $conn->prepare($sqlInsert);
        }

        $stmt->execute([
            ':idUsuario' => $idUsuario,
            ':idTarefa' => $idTarefa
        ]);

        // Busca os pontos da tarefa
        $sqlPontos = "SELECT pontos_tarefa FROM tarefas WHERE id_tarefa = :idTarefa";
        $stmt = $conn->prepare($sqlPontos);
        $stmt->execute([':idTarefa' => $idTarefa]);
        $pontos = (int) $stmt->fetchColumn();

        // Atualiza ou insere na tabela de pontos do usuário
        $sqlVerificaPontos = "SELECT COUNT(*) FROM pontos_usuario WHERE id_usuario = :idUsuario";
        $stmt = $conn->prepare($sqlVerificaPontos);
        $stmt->execute([':idUsuario' => $idUsuario]);
        $existePontos = $stmt->fetchColumn() > 0;

        if ($existePontos) {
            $sqlUpdatePontos = "
                UPDATE pontos_usuario 
                SET pontos_acumulados = pontos_acumulados + :pontos,
                    data_atualizacao = NOW()
                WHERE id_usuario = :idUsuario
            ";
            $stmt = $conn->prepare($sqlUpdatePontos);
        } else {
            $sqlInsertPontos = "
                INSERT INTO pontos_usuario (id_usuario, pontos_acumulados)
                VALUES (:idUsuario, :pontos)
            ";
            $stmt = $conn->prepare($sqlInsertPontos);
        }

        $stmt->execute([
            ':idUsuario' => $idUsuario,
            ':pontos' => $pontos
        ]);

        $conn->commit();
        return true;

    } catch (Exception $e) {
        $conn->rollBack();
        error_log('Erro ao marcar tarefa e atualizar pontos: ' . $e->getMessage());
        return false;
    }
}

}  
