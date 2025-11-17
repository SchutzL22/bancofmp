<?php
session_start();

define('BASE_URL', 'http://localhost/Bancophp/public');

spl_autoload_register(function ($class_name) {
    $paths = ['../model/', '../controller/'];
    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once '../config/Database.php';

$route = $_GET['route'] ?? 'login';

$usuarioController = new UsuarioController();
$contaController = new ContaController();

switch ($route) {
    case 'login':
        $usuarioController->login();
        break;
    case 'registrar':
        $usuarioController->registrar();
        break;
    case 'logout':
        $usuarioController->logout();
        break;
    case 'dashboard':
        $contaController->dashboard();
        break;
    case 'transferir':
        $contaController->transferir();
        break;
    case 'admin':
        $contaController->adminDashboard();
        break;
    default:
        header('Location: ' . BASE_URL . '/login');
        exit;
}
?>