<section class="jobs-page">
    <div class="jobs-page-head">
        <div>
            <a href="index.php?page=jobs&action=show&id=<?= (int) $job['id'] ?>" class="jobs-back">← Voltar aos detalhes</a>
            <h1>Editar candidatura</h1>
            <p>Atualize as informações de <?= e((string) $job['company_name']) ?>.</p>
        </div>
    </div>
    <div class="jobs-panel">
        <?php
        $actionUrl = 'index.php?page=jobs&action=update&id=' . (int) $job['id'];
        $submitText = 'Salvar alterações';
        require __DIR__ . '/_form.php';
        ?>
    </div>
</section>
