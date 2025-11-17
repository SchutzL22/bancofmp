<?php
class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function registrar() {
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $confirma_senha = $_POST['confirma_senha'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = "Email inválido.";
            } elseif (strlen($senha) != 6 || !is_numeric($senha)) {
                $erro = "A senha deve conter exatamente 6 números.";
            } elseif ($senha != $confirma_senha) {
                $erro = "As senhas não conferem.";
            } else {
                $resultado = $this->usuarioModel->registrar($email, $senha);
                if ($resultado === true) {
                    header('Location: ' . BASE_URL . '/login?success=1');
                    exit;
                } else {
                    $erro = "Não foi possível registrar. O email já pode estar em uso.";
                }
            }
        }
        require_once '../view/usuario/registrar.php';
    }

    public function login() {
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuario = $this->usuarioModel->login($email, $senha);

            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_tipo'] = $usuario['tipo_usuario'];
                
                if ($usuario['tipo_usuario'] == 'admin') {
                    header('Location: ' . BASE_URL . '/admin');
                } else {
                    header('Location: ' . BASE_URL . '/dashboard');
                }
                exit;
            } else {
                $erro = "Email ou senha incorretos.";
            }
        }
        require_once '../view/usuario/login.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
?>