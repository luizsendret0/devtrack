<section class="jobs-page">
    <div class="jobs-page-head">
        <div>
            <a href="index.php?page=jobs" class="jobs-back">← Minhas candidaturas</a>
            <h1><?= e((string) $job['job_title']) ?></h1>
            <p><?= e((string) $job['company_name']) ?></p>
        </div>
        <a class="jobs-btn jobs-btn-primary" href="index.php?page=jobs&action=edit&id=<?= (int) $job['id'] ?>">Editar vaga</a>
    </div>

    <?php if (is_array($flash)): ?>
        <div class="jobs-alert <?= ($flash['type'] ?? '') === 'success' ? 'jobs-alert-success' : 'jobs-alert-error' ?>" role="status">
            <?= e((string) ($flash['message'] ?? '')) ?>
        </div>
    <?php endif; ?>

    <div class="jobs-details-grid">
        <div class="jobs-panel">
            <h2>Informações da oportunidade</h2>
            <dl class="jobs-details">
                <div><dt>Empresa</dt><dd><?= e((string) $job['company_name']) ?></dd></div>
                <div><dt>Cargo</dt><dd><?= e((string) $job['job_title']) ?></dd></div>
                <div><dt>Localização</dt><dd><?= e((string) ($job['location'] ?: 'Não informada')) ?></dd></div>
                <div><dt>Modalidade</dt><dd><?= e(['presencial' => 'Presencial', 'hibrido' => 'Híbrido', 'remoto' => 'Remoto'][$job['work_model'] ?? ''] ?? 'Não informada') ?></dd></div>
                <div><dt>Tipo</dt><dd><?= e(['estagio' => 'Estágio', 'junior' => 'Júnior', 'pleno' => 'Pleno', 'senior' => 'Sênior', 'outro' => 'Outro'][$job['employment_type'] ?? ''] ?? 'Não informado') ?></dd></div>
                <div><dt>Salário</dt><dd><?= $job['salary'] !== null ? 'R$ ' . e(number_format((float) $job['salary'], 2, ',', '.')) : 'Não informado' ?></dd></div>
                <div><dt>Data da candidatura</dt><dd><?= $job['applied_at'] ? e(date('d/m/Y', strtotime((string) $job['applied_at']))) : 'Não informada' ?></dd></div>
                <div><dt>Link</dt><dd>
                    <?php if ($job['job_url']): ?>
                        <a href="<?= e((string) $job['job_url']) ?>" rel="noopener noreferrer" target="_blank">Abrir vaga ↗</a>
                    <?php else: ?>—<?php endif; ?>
                </dd></div>
            </dl>
            <h3>Tecnologias exigidas</h3>
            <?php if (empty($skillNames)): ?>
                <p class="jobs-notes">Nenhuma tecnologia informada. Edite a vaga para adicioná-las.</p>
            <?php else: ?>
                <div class="skills-tags" aria-label="Tecnologias exigidas">
                    <?php foreach ($skillNames as $skillName): ?>
                        <span class="skills-tag"><?= e($skillName) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <h3>Observações</h3>
            <p class="jobs-notes"><?= $job['notes'] ? nl2br(e((string) $job['notes'])) : 'Nenhuma observação cadastrada.' ?></p>
        </div>

        <div class="jobs-panel jobs-actions-panel">
            <h2>Etapa do processo</h2>
            <p class="jobs-hint">Atualize o status conforme sua candidatura avançar.</p>
            <form method="post" action="index.php?page=jobs&action=status&id=<?= (int) $job['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <label class="jobs-field"><span>Status atual</span>
                    <select name="status">
                        <?php foreach ($statuses as $value => $label): ?>
                            <option value="<?= e($value) ?>" <?= $job['status'] === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button class="jobs-btn jobs-btn-primary jobs-btn-block" type="submit">Atualizar status</button>
            </form>
            <div class="jobs-danger-zone">
                <h3>Excluir candidatura</h3>
                <p>Essa ação não pode ser desfeita.</p>
                <form class="jobs-delete-form" method="post" action="index.php?page=jobs&action=delete&id=<?= (int) $job['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                    <button class="jobs-btn jobs-btn-danger" type="submit">Excluir definitivamente</button>
                </form>
            </div>
        </div>
    </div>
</section>
