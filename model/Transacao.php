<?php
class Transacao {
    private $db;

    public function __construct() {
        $this->db = Database::conectar();
    }

    public function registrar($id_origem, $id_destino, $valor, $taxa, $metodo) {
        $stmt = $this->db->prepare("INSERT INTO transacoes (id_usuario_origem, id_usuario_destino, valor, taxa, metodo) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$id_origem, $id_destino, $valor, $taxa, $metodo]);
    }

    public function getHistorico($id_usuario) {
        $sql = "
            SELECT 
                t.*, 
                u_origem.email AS email_origem,
                u_destino.email AS email_destino
            FROM transacoes t
            LEFT JOIN usuarios u_origem ON t.id_usuario_origem = u_origem.id
            LEFT JOIN usuarios u_destino ON t.id_usuario_destino = u_destino.id
            WHERE t.id_usuario_origem = ? OR t.id_usuario_destino = ?
            ORDER BY t.data DESC
            LIMIT 20
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_usuario, $id_usuario]);
        return $stmt->fetchAll();
    }
}
?>