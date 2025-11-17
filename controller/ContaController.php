<?php
class ContaController {
    private $contaModel;
    private $usuarioModel;
    private $transacaoModel;

    public function __construct() {
        $this->contaModel = new Conta();
        $this->usuarioModel = new Usuario();
        $this->transacaoModel = new Transacao();
        $this->checkAuth();
    }

    private function checkAuth() {
        $public_routes = ['login', 'registrar'];
        $current_route = $_GET['route'] ?? 'login';

        if (!isset($_SESSION['usuario_id']) && !in_array($current_route, $public_routes)) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    private function checkAdmin() {
        if ($_SESSION['usuario_tipo'] != 'admin') {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }

    public function dashboard() {
        $id_usuario = $_SESSION['usuario_id'];
        $saldo = $this->contaModel->getSaldo($id_usuario);
        $historico = $this->transacaoModel->getHistorico($id_usuario);
        
        require_once '../view/conta/dashboard.php';
    }

    public function transferir() {
        $erro = '';
        $sucesso = '';
        $id_origem = $_SESSION['usuario_id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email_destino = $_POST['email_destino'];
            $valor = (float)$_POST['valor'];
            $metodo = $_POST['metodo'];
            $senha = $_POST['senha'];

            if (!$this->usuarioModel->checkSenha($id_origem, $senha)) {
                $erro = "Senha da transação incorreta.";
            }
            elseif ($valor <= 0) {
                $erro = "O valor da transferência deve ser positivo.";
            }
            elseif (!($usuario_destino = $this->usuarioModel->getByEmail($email_destino))) {
                $erro = "Email de destino não encontrado.";
            }
            elseif ($usuario_destino['id'] == $id_origem) {
                $erro = "Você não pode transferir para si mesmo.";
            }
            else {
                $id_destino = $usuario_destino['id'];
                
                $taxa = 0.00;
                if ($metodo == 'ClodoCard') {
                    $taxa = $valor * 0.05;
                }
                $valor_total_debito = $valor + $taxa;

                $saldo_origem = $this->contaModel->getSaldo($id_origem);
                if ($saldo_origem < $valor_total_debito) {
                    $erro = "Saldo insuficiente. (Necessário: R$ " . number_format($valor_total_debito, 2, ',', '.') . ")";
                } else {
                    $transferencia_ok = $this->contaModel->realizarTransferencia($id_origem, $id_destino, $valor, $taxa, $metodo);
                    
                    if ($transferencia_ok === true) {
                        $this->transacaoModel->registrar($id_origem, $id_destino, $valor, $taxa, $metodo);
                        $sucesso = "Transferência de R$ " . number_format($valor, 2, ',', '.') . " realizada com sucesso!";
                    } else {
                        $erro = "Erro ao processar a transação: " . $transferencia_ok;
                    }
                }
            }
        }

        $saldo_atual = $this->contaModel->getSaldo($id_origem);
        require_once '../view/conta/transferir.php';
    }

    public function adminDashboard() {
        $this->checkAdmin();
        $erro = '';
        $sucesso = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email_usuario = $_POST['email_usuario'];
            $valor = (float)$_POST['valor'];

            $usuario = $this->usuarioModel->getByEmail($email_usuario);

            if (!$usuario) {
                $erro = "Usuário não encontrado.";
            } elseif ($valor <= 0) {
                $erro = "O valor deve ser positivo.";
            } else {
                $this->contaModel->adminAddSaldo($usuario['id'], $valor);
                $sucesso = "R$ " . number_format($valor, 2, ',', '.') . " adicionados à conta de " . $email_usuario;
            }
        }

        require_once '../view/admin/dashboard.php';
    }
}
?>