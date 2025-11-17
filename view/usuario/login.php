<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Banco Digital</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h2>Login</h2>
        <p>Acesse sua conta no Banco Digital.</p>
        
        <?php if (!empty($erro)): ?>
            <div class="mensagem erro"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="mensagem sucesso">Cadastro realizado com sucesso! Faça seu login.</div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/login" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha (6 números):</label>
                <input type="password" name="senha" id="senha" required maxlength="6" pattern="\d{6}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">Entrar</button>
            </div>
        </form>
        <div class="auth-link">
            <p>Não tem conta? <a href="<?php echo BASE_URL; ?>/registrar">Registre-se aqui</a></p>
        </div>
    </div>
</body>
</html>