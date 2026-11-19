<?php
// A variável $dashboard é preparada pelo DashboardController.
// Não existem mais empresas, números ou percentuais fictícios nesta página.
$workLabels = [
    'presencial' => 'Presencial',
    'hibrido' => 'Híbrido',
    'remoto' => 'Remoto',
];
$statusLabels = [
    'salva' => 'Salva',
    'candidatado' => 'Candidatada',
    'entrevista' => 'Entrevista',
    'aprovado' => 'Aprovada',
    'recusado' => 'Recusada',
    'desistiu' => 'Desistiu',
];
?>

<div class="dashboard-header">
    <div>
        <h1>Visão geral</h1>
        <p>Suas candidaturas e processos seletivos, atualizados com os dados do MySQL.</p>
    </div>

    <a class="dashboard-new-button" href="index.php?page=jobs&amp;action=create">
        + Nova candidatura
    </a>
</div>

<div class="dashboard-layout">
    <div class="dashboard-main">
        <section class="stats-grid" aria-label="Resumo das candidaturas">
            <div class="stat-card">
                <span>Total de candidaturas</span>
                <div class="stat-value"><?= (int) $dashboard['total'] ?></div>
            </div>
            <div class="stat-card">
                <span>Candidatadas</span>
                <div class="stat-value"><?= (int) $dashboard['applied'] ?></div>
            </div>
            <div class="stat-card">
                <span>Entrevistas</span>
                <div class="stat-value"><?= (int) $dashboard['interviews'] ?></div>
            </div>
            <div class="stat-card highlight">
                <span>Aprovadas</span>
                <div class="stat-value"><?= (int) $dashboard['approved'] ?></div>
            </div>
        </section>

        <section class="kanban-panel" aria-labelledby="kanban-title">
            <div class="panel-header">
                <h2 id="kanban-title">Acompanhamento de candidaturas</h2>
                <a class="dashboard-link" href="index.php?page=jobs">Ver todas</a>
            </div>

            <p class="kanban-instructions">Arraste um cartão para mudar de etapa. No celular ou pelo teclado, use <strong>Alterar etapa</strong>.</p>
            <?php if ($dashboard['total'] === 0): ?>
                <div class="dashboard-empty">
                    <h3>Você ainda não cadastrou nenhuma vaga</h3>
                    <p>Cadastre uma oportunidade e ela aparecerá automaticamente no seu dashboard.</p>
                    <a class="dashboard-new-button" href="index.php?page=jobs&amp;action=create">Cadastrar primeira vaga</a>
                </div>
            <?php else: ?>
                <div class="kanban-board dashboard-live-kanban" data-csrf-token="<?= e(csrf_token()) ?>" aria-label="Quadro de candidaturas. Arraste os cartões ou use Alterar etapa.">
                    <?php foreach ($dashboard['columns'] as $column): ?>
                        <div class="kanban-column" data-stage="<?= e((string) $column['key']) ?>">
                            <div class="column-header">
                                <h3><?= e($column['label']) ?></h3>
                                <span><?= (int) $column['count'] ?></span>
                            </div>

                            <div class="column-content">
                                <?php if (!$column['jobs']): ?>
                                    <p class="dashboard-column-empty">Nenhuma vaga nesta etapa.</p>
                                <?php else: ?>
                                    <?php foreach ($column['jobs'] as $job): ?>
                                        <article class="job-card" draggable="true" data-job-id="<?= (int) $job['id'] ?>" data-current-status="<?= e((string) $job['status']) ?>" title="Arraste para outra etapa ou use Alterar etapa">
                                            <a class="dashboard-job-link" href="index.php?page=jobs&amp;action=show&amp;id=<?= (int) $job['id'] ?>">
                                                <div class="job-company">
                                                    <span class="company-avatar" aria-hidden="true">
                                                        <?= e(function_exists('mb_substr') ? mb_substr((string) $job['company_name'], 0, 1, 'UTF-8') : substr((string) $job['company_name'], 0, 1)) ?>
                                                    </span>
                                                    <div>
                                                        <strong><?= e((string) $job['company_name']) ?></strong>
                                                        <p><?= e((string) $job['job_title']) ?></p>
                                                    </div>
                                                </div>
                                                <div class="job-tags">
                                                    <?php if (!empty($job['work_model']) && isset($workLabels[$job['work_model']])): ?>
                                                        <span><?= e($workLabels[$job['work_model']]) ?></span>
                                                    <?php endif; ?>
                                                    <span><?= e($statusLabels[$job['status']] ?? (string) $job['status']) ?></span>
                                                </div>
                                            </a>
                                            <details class="kanban-move">
                                                <summary>Alterar etapa</summary>
                                                <form class="kanban-status-form" method="post" action="index.php?page=jobs&amp;action=status&amp;id=<?= (int) $job['id'] ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                                                    <label for="kanban-status-<?= (int) $job['id'] ?>">Mover para</label>
                                                    <select id="kanban-status-<?= (int) $job['id'] ?>" name="status">
                                                        <?php foreach ($statusLabels as $value => $label): ?>
                                                            <option value="<?= e($value) ?>" <?= $job['status'] === $value ? 'selected' : '' ?>><?= e($label) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit">Salvar</button>
                                                </form>
                                            </details>
                                        </article>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if ($column['count'] > count($column['jobs'])): ?>
                                    <a class="dashboard-more" href="index.php?page=jobs<?= $column['filter'] !== null ? '&amp;status=' . rawurlencode($column['filter']) : '' ?>">
                                        Ver mais <?= (int) ($column['count'] - count($column['jobs'])) ?> vaga(s)
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <dialog class="kanban-close-dialog" id="kanban-close-dialog" aria-labelledby="kanban-close-title">
                    <h3 id="kanban-close-title">Como essa candidatura terminou?</h3>
                    <p>A coluna Encerradas reúne dois tipos de encerramento.</p>
                    <div class="kanban-dialog-actions">
                        <button type="button" data-closed-status="recusado">Recusada</button>
                        <button type="button" data-closed-status="desistiu">Desisti da vaga</button>
                        <button type="button" data-closed-status="">Cancelar</button>
                    </div>
                </dialog>
                <p id="kanban-feedback" class="kanban-feedback" aria-live="polite" role="status"></p>
            <?php endif; ?>
        </section>
    </div>

    <aside class="study-panel" aria-label="Área de Estudos">
        <div class="study-heading">
            <div>
                <span class="study-icon" aria-hidden="true">✧</span>
                <h2>Área de Estudos</h2>
            </div>
            <p>Em breve, recomendações baseadas nas tecnologias das suas vagas.</p>
        </div>

        <section class="study-section">
            <h3>Aprendizado conectado à carreira</h3>
            <p class="dashboard-study-note">
                Nesta versão, o DevTrack já acompanha suas candidaturas reais.
                A análise de tecnologias e as trilhas personalizadas entram numa próxima etapa.
            </p>
            <a class="study-button" href="index.php?page=studies">Explorar Área de Estudos</a>
        </section>

        <section class="study-section">
            <h3>Seu progresso</h3>
            <p class="dashboard-study-note">
                Nenhuma porcentagem fictícia: quando o módulo de estudos estiver pronto,
                seu progresso será calculado a partir das atividades concluídas.
            </p>
        </section>
    </aside>
</div>
