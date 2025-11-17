<?php
class Conta {
    private $db;

    public function __construct() {
        $this->db = Database::conectar();
    }

    public function getSaldo($id_usuario) {
        $stmt = $this->db->prepare("SELECT saldo FROM contas WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $resultado = $stmt->fetch();
        return $resultado ? $resultado['saldo'] : 0;
    }

    public function updateSaldo($id_usuario, $novo_saldo) {
        $stmt = $this->db->prepare("UPDATE contas SET saldo = ? WHERE id_usuario = ?");
        return $stmt->execute([$novo_saldo, $id_usuario]);
    }

    public function adminAddSaldo($id_usuario, $valor) {
        $saldo_atual = $this->getSaldo($id_usuario);
        $novo_saldo = $saldo_atual + $valor;
        return $this->updateSaldo($id_usuario, $novo_saldo);
    }

    public function realizarTransferencia($id_origem, $id_destino, $valor, $taxa, $metodo) {
        $valor_total_debito = $valor + $taxa;
        
        try {
            $this->db->beginTransaction();

            $saldo_origem = $this->getSaldo($id_origem);
            $this->updateSaldo($id_origem, $saldo_origem - $valor_total_debito);

            $saldo_destino = $this->getSaldo($id_destino);
            $this->updateSaldo($id_destino, $saldo_destino + $valor);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }
}
?>