<?php require_once '../view/template/header.php'; ?>

<h2>Painel Administrativo</h2>
<p>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['usuario_email']); ?> (Admin)</strong>.</p>
<p>Use este painel para adicionar saldo manualmente a contas de usuários.</p>

<div class="form-container">
    <?php if (!empty($erro)): ?>
        <div class="mensagem erro"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <?php if (!empty($sucesso)): ?>
        <div class="mensagem sucesso"><?php echo htmlspecialchars($sucesso); ?></div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>/admin" method="POST">
        <div class="form-group">
            <label for="email_usuario">Email do Usuário:</label>
            <input type="email" name="email_usuario" id="email_usuario" required>
        </div>
        <div class="form-group">
            <label for="valor">Valor a Adicionar (R$):</label>
            <input type="number" name="valor" id="valor" step="0.01" min="0.01" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-primary">Adicionar Saldo</button>
        </div>
    </form>
</div>

<?php require_once '../view/template/footer.php'; ?>