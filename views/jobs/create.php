<section class="jobs-page">
    <div class="jobs-page-head">
        <div>
            <a href="index.php?page=jobs" class="jobs-back">← Voltar às candidaturas</a>
            <h1>Nova candidatura</h1>
            <p>Registre a oportunidade para acompanhar cada etapa do processo.</p>
        </div>
    </div>
    <div class="jobs-panel">
        <?php
        $actionUrl = 'index.php?page=jobs&action=store';
        $submitText = 'Salvar candidatura';
        require __DIR__ . '/_form.php';
        ?>
    </div>
</section>
