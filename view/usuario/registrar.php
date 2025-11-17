<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - Banco Digital</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <h2>Criar Conta</h2>
        <p>Crie sua conta com email e senha de 6 dígitos.</p>

        <?php if (!empty($erro)): ?>
            <div class="mensagem erro"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/registrar" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha (exatos 6 números):</label>
                <input type="password" name="senha" id="senha" required maxlength="6" pattern="\d{6}" title="A senha deve conter exatamente 6 números">
            </div>
             <div class="form-group">
                <label for="confirma_senha">Confirme a Senha:</label>
                <input type="password" name="confirma_senha" id="confirma_senha" required maxlength="6" pattern="\d{6}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">Registrar</button>
            </div>
        </form>
        <div class="auth-link">
            <p>Já tem conta? <a href="<?php echo BASE_URL; ?>/login">Faça login</a></p>
        </div>
    </div>
</body>
</html>