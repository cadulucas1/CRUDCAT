<?php

require_once __DIR__ . '/../connect.php';

class UsuarioModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function atualizarPerfilComSenha($id, $nome, $email, $telefone, $senhaHash)
    {
        $sql = "UPDATE usuario 
                SET nome_usuario = ?, email_usuario = ?, telefone_usuario = ?, senha_usuario = ?
              WHERE id_usuario = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([$nome, $email, $telefone, $senhaHash, $id]);
    }

    public function atualizarPerfilSemSenha($id, $nome, $email, $telefone)
    {
        $sql = "UPDATE usuario 
                SET nome_usuario = ?, email_usuario = ?, telefone_usuario = ?
              WHERE id_usuario = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([$nome, $email, $telefone, $id]);
    }

    public function getUsuarioById($id)
    {
        $sql = "SELECT id_usuario, nome_usuario, email_usuario, telefone_usuario 
                FROM usuario 
               WHERE id_usuario = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
