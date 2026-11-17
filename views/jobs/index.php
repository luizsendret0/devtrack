<?php
$total = array_sum($counts);
$active = ($counts['candidatado'] ?? 0) + ($counts['entrevista'] ?? 0);
?>
<section class="jobs-page">
    <div class="jobs-page-head">
        <div>
            <h1>Minhas candidaturas</h1>
            <p>Organize as oportunidades e acompanhe os processos seletivos.</p>
        </div>
        <a class="jobs-btn jobs-btn-primary" href="index.php?page=jobs&action=create">+ Nova candidatura</a>
    </div>

    <?php if (is_array($flash)): ?>
        <div class="jobs-alert <?= ($flash['type'] ?? '') === 'success' ? 'jobs-alert-success' : 'jobs-alert-error' ?>" role="status">
            <?= e((string) ($flash['message'] ?? '')) ?>
        </div>
    <?php endif; ?>

    <div class="jobs-stats">
        <div class="jobs-stat"><span>Total de vagas</span><strong><?= $total ?></strong></div>
        <div class="jobs-stat"><span>Em andamento</span><strong><?= $active ?></strong></div>
        <div class="jobs-stat"><span>Entrevistas</span><strong><?= $counts['entrevista'] ?? 0 ?></strong></div>
        <div class="jobs-stat"><span>Aprovadas</span><strong><?= $counts['aprovado'] ?? 0 ?></strong></div>
    </div>

    <div class="jobs-panel">
        <form class="jobs-filters" method="get" action="index.php">
            <input type="hidden" name="page" value="jobs">
            <label class="jobs-field"><span>Pesquisar</span>
                <input type="search" name="q" value="<?= e($search) ?>" placeholder="Empresa ou cargo">
            </label>
            <label class="jobs-field"><span>Status</span>
                <select name="status">
                    <option value="">Todos os status</option>
                    <?php foreach ($statuses as $value => $title): ?>
                        <option value="<?= e($value) ?>" <?= $filter === $value ? 'selected' : '' ?>><?= e($title) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button class="jobs-btn jobs-btn-muted" type="submit">Filtrar</button>
            <a class="jobs-clear" href="index.php?page=jobs">Limpar</a>
        </form>

        <?php if (!$jobs): ?>
            <div class="jobs-empty">
                <h2>Nenhuma candidatura encontrada</h2>
                <p>Comece cadastrando uma vaga ou altere os filtros da pesquisa.</p>
                <a class="jobs-btn jobs-btn-primary" href="index.php?page=jobs&action=create">Cadastrar vaga</a>
            </div>
        <?php else: ?>
            <div class="jobs-table-scroll">
                <table class="jobs-table">
                    <thead><tr>
                        <th>Empresa / Cargo</th><th>Modalidade</th><th>Status</th><th>Cadastro</th><th>Ações</th>
                    </tr></thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr>
                                <td>
                                    <strong><?= e((string) $job['company_name']) ?></strong>
                                    <span class="jobs-secondary"><?= e((string) $job['job_title']) ?></span>
                                </td>
                                <td><?= e(['presencial' => 'Presencial', 'hibrido' => 'Híbrido', 'remoto' => 'Remoto'][$job['work_model'] ?? ''] ?? '—') ?></td>
                                <td><span class="jobs-status jobs-status-<?= e((string) $job['status']) ?>"><?= e($statuses[$job['status']] ?? (string) $job['status']) ?></span></td>
                                <td><?= e(date('d/m/Y', strtotime((string) $job['created_at']))) ?></td>
                                <td class="jobs-row-actions">
                                    <a href="index.php?page=jobs&action=show&id=<?= (int) $job['id'] ?>">Detalhes</a>
                                    <a href="index.php?page=jobs&action=edit&id=<?= (int) $job['id'] ?>">Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p class="jobs-note">Exibindo até 100 resultados por consulta. Paginação será adicionada depois.</p>
        <?php endif; ?>
    </div>
</section>
