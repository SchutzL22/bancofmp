<?php
$is_logged_in = isset($_SESSION['usuario_id']);
$is_admin = $is_logged_in && $_SESSION['usuario_tipo'] == 'admin';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco Digital</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><a href="<?php echo BASE_URL; ?>/dashboard">Banco Digital</a></h1>
            <nav>
                <ul>
                    <?php if ($is_logged_in): ?>
                        <?php if ($is_admin): ?>
                            <li><a href="<?php echo BASE_URL; ?>/admin">Painel Admin</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/dashboard">Minha Conta</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/transferir">Transferir</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo BASE_URL; ?>/logout">Sair</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>/login">Login</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/registrar">Registrar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">