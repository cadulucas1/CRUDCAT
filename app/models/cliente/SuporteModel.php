<?php
require_once __DIR__ . '/../connect.php'; 

class SuporteModel
{
    private Database $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    public function enviarMensagemSuporte($assunto, $mensagem, $idUsuario): bool {
        $sql = "INSERT INTO suporte (assunto, mensagem, id_usuario, data_envio) VALUES (:assunto, :mensagem, :id_usuario, NOW())";
        
        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':assunto', $assunto, PDO::PARAM_STR);
            $stmt->bindValue(':mensagem', $mensagem, PDO::PARAM_STR);
            $stmt->bindValue(':id_usuario', $idUsuario, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao salvar mensagem de suporte: " . $e->getMessage());
            return false;
        }
    }
}