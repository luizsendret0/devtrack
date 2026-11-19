<?php
// Variáveis recebidas de create.php ou edit.php: $old, $errors, $statuses,
// $workModels, $employmentTypes, $actionUrl, $submitText.
$val = static fn(string $key): string => e((string) ($old[$key] ?? ''));
?>
<?php if (!empty($errors)): ?>
    <div class="jobs-alert jobs-alert-error" role="alert">
        <strong>Confira os campos:</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= e((string) $error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="jobs-form" method="post" action="<?= e($actionUrl) ?>">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

    <div class="jobs-fields">
        <label class="jobs-field">
            <span>Empresa <em>*</em></span>
            <input type="text" name="company_name" value="<?= $val('company_name') ?>"
                   maxlength="150" autocomplete="organization" required>
        </label>
        <label class="jobs-field">
            <span>Cargo <em>*</em></span>
            <input type="text" name="job_title" value="<?= $val('job_title') ?>"
                   maxlength="150" required>
        </label>
        <label class="jobs-field">
            <span>Localização</span>
            <input type="text" name="location" value="<?= $val('location') ?>"
                   maxlength="150" placeholder="Joinville, SC">
        </label>
        <label class="jobs-field">
            <span>Modalidade</span>
            <select name="work_model">
                <option value="">Não informado</option>
                <?php foreach ($workModels as $key => $label): ?>
                    <option value="<?= e($key) ?>" <?= ($old['work_model'] ?? '') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="jobs-field">
            <span>Tipo da vaga</span>
            <select name="employment_type">
                <option value="">Não informado</option>
                <?php foreach ($employmentTypes as $key => $label): ?>
                    <option value="<?= e($key) ?>" <?= ($old['employment_type'] ?? '') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="jobs-field">
            <span>Salário informado (R$)</span>
            <input type="number" name="salary" min="0" max="99999999.99" step="0.01"
                   value="<?= $val('salary') ?>" placeholder="2500.00">
        </label>
        <label class="jobs-field jobs-field-wide">
            <span>Link da vaga</span>
            <input type="url" name="job_url" value="<?= $val('job_url') ?>"
                   maxlength="2048" placeholder="https://...">
        </label>
        <label class="jobs-field">
            <span>Status <em>*</em></span>
            <select name="status" required>
                <?php foreach ($statuses as $key => $label): ?>
                    <option value="<?= e($key) ?>" <?= ($old['status'] ?? 'salva') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="jobs-field">
            <span>Data da candidatura</span>
            <input type="date" name="applied_at" value="<?= $val('applied_at') ?>">
        </label>
        <label class="jobs-field jobs-field-wide">
            <span>Tecnologias exigidas</span>
            <textarea name="skills_text" rows="2" maxlength="1500"
                      placeholder="JavaScript, React, SQL, Git, PHP"
                      aria-describedby="job-skills-help"><?= $val('skills_text') ?></textarea>
            <small class="skills-help" id="job-skills-help">Separe por vírgula. Até 15 tecnologias por vaga. Ex.: C#, C++, Node.js, React.</small>
        </label>
        <label class="jobs-field jobs-field-wide">
            <span>Observações</span>
            <textarea name="notes" maxlength="5000" rows="5"
                      placeholder="Contatos, próximos passos e outras informações..."><?= $val('notes') ?></textarea>
        </label>
    </div>

    <div class="jobs-form-actions">
        <a class="jobs-btn jobs-btn-muted" href="index.php?page=jobs">Cancelar</a>
        <button class="jobs-btn jobs-btn-primary" type="submit"><?= e($submitText) ?></button>
    </div>
</form>
