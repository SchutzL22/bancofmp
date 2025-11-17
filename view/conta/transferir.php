<?php require_once '../view/template/header.php'; ?>

<h2>Realizar Transferência</h2>
<p>Seu saldo atual: <strong>R$ <?php echo number_format($saldo_atual, 2, ',', '.'); ?></strong></p>

<div class="form-container">
    <?php if (!empty($erro)): ?>
        <div class="mensagem erro"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <?php if (!empty($sucesso)): ?>
        <div class="mensagem sucesso"><?php echo htmlspecialchars($sucesso); ?></div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>/transferir" method="POST">
        <div class="form-group">
            <label for="email_destino">Email de Destino:</label>
            <input type="email" name="email_destino" id="email_destino" required>
        </div>
        <div class="form-group">
            <label for="valor">Valor (R$):</label>
            <input type="number" name="valor" id="valor" step="0.01" min="0.01" required>
        </div>
        
        <div class="form-group">
            <label>Método de Transferência:</label>
            <div class="radio-group">
                <input type="radio" name="metodo" id="pixcler" value="PIXcler" checked>
                <label for="pixcler">PIXcler (Sem taxa)</label>
            </div>
            <div class="radio-group">
                <input type="radio" name="metodo" id="clodocard" value="ClodoCard">
                <label for="clodocard">ClodoCard (Taxa de 5% - "Taxael")</label>
            </div>
        </div>

        <div class="form-group">
            <label for="senha">Senha da Transação (6 números):</label>
            <input type="password" name="senha" id="senha" required maxlength="6" pattern="\d{6}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn-primary">Confirmar Transferência</button>
        </div>
    </form>
</div>


<?php require_once '../view/template/footer.php'; ?>