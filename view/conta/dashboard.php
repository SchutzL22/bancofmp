<?php require_once '../view/template/header.php'; ?>

<h2>Minha Conta</h2>
<p>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['usuario_email']); ?></strong>!</p>

<div class="card-saldo">
    <h3>Saldo Atual</h3>
    <div class="saldo-valor">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></div>
    <a href="<?php echo BASE_URL; ?>/transferir" class="btn-primary">Nova Transferência</a>
</div>

<h3>Histórico de Transações</h3>
<div class="historico-container">
    <?php if (empty($historico)): ?>
        <p>Nenhuma transação encontrada.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Taxa</th>
                    <th>Destino/Origem</th>
                    <th>Método</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historico as $t): 
                    $is_saida = ($t['id_usuario_origem'] == $_SESSION['usuario_id']);
                ?>
                    <tr class="<?php echo $is_saida ? 'saida' : 'entrada'; ?>">
                        <td><?php echo date('d/m/Y H:i', strtotime($t['data'])); ?></td>
                        <td><?php echo $is_saida ? 'Envio' : 'Recebimento'; ?></td>
                        <td>R$ <?php echo number_format($t['valor'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($t['taxa'], 2, ',', '.'); ?></td>
                        <td>
                            <?php 
                            echo htmlspecialchars($is_saida ? $t['email_destino'] : $t['email_origem']); 
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($t['metodo']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require_once '../view/template/footer.php'; ?>