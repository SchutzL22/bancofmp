<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::conectar();
    }

    public function registrar($email, $senha, $tipo = 'normal') {
        $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
        
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO usuarios (email, senha, tipo_usuario) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hash_senha, $tipo]);
            
            $id_usuario = $this->db->lastInsertId();

            $stmt_conta = $this->db->prepare("INSERT INTO contas (id_usuario, saldo) VALUES (?, 0.00)");
            $stmt_conta->execute([$id_usuario]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }

    public function login($email, $senha) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function checkSenha($id_usuario, $senha) {
        $usuario = $this->getById($id_usuario);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return true;
        }
        return false;
    }
}
?>