
<?php

// Dados fictícios para desenvolver a interface.
// Posteriormente serão consultados no MySQL.

$columns = [
    [
        'title' => 'Salvas',
        'jobs' => [
            ['company' => 'Mercado Livre', 'role' => 'Front-end Jr.', 'tags' => ['Remoto', 'CLT']],
            ['company' => 'TOTVS', 'role' => 'Analista de Sistemas', 'tags' => ['Presencial', 'CLT']],
            ['company' => 'Stone', 'role' => 'Desenvolvedor PHP Jr.', 'tags' => ['Híbrido', 'CLT']]
        ]
    ],
    [
        'title' => 'Aplicadas',
        'jobs' => [
            ['company' => 'Nubank', 'role' => 'Desenvolvedor Back-end Jr.', 'tags' => ['Remoto', 'PJ']],
            ['company' => 'iFood', 'role' => 'Dev Full Stack Jr.', 'tags' => ['Híbrido', 'CLT']],
            ['company' => 'Ambev', 'role' => 'Analista de TI Jr.', 'tags' => ['Presencial', 'CLT']],
            ['company' => 'Empresa A', 'role' => 'Estágio em TI', 'tags' => ['Remoto']],
            ['company' => 'Empresa B', 'role' => 'Estágio em Desenvolvimento', 'tags' => ['Híbrido']]
        ]
    ],
    [
        'title' => 'Entrevistas',
        'jobs' => [
            ['company' => 'Itaú', 'role' => 'Desenvolvedor de Sistemas', 'tags' => ['18 nov. às 14h']],
            ['company' => 'VTEX', 'role' => 'Dev Front-end Jr.', 'tags' => ['20 nov. às 10h']],
            ['company' => 'RD Station', 'role' => 'Analista de Desenvolvimento', 'tags' => ['21 nov. às 16h']]
        ]
    ],
    [
        'title' => 'Ofertas',
        'jobs' => [
            ['company' => 'Banco do Brasil', 'role' => 'Desenvolvedor Web Jr.', 'tags' => ['Oferta recebida']]
        ]
    ]
];

$total = array_sum(array_map(
    fn($column) => count($column['jobs']),
    $columns
));

$technologies = [
    ['name' => 'PHP', 'percentage' => 92],
    ['name' => 'MySQL', 'percentage' => 75],
    ['name' => 'JavaScript', 'percentage' => 58],
    ['name' => 'React', 'percentage' => 42]
];

function escapeText(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>

<div class="dashboard-header">
    <div>
        <h1>Visão geral</h1>
        <p>Acompanhe suas candidaturas e alcance sua próxima oportunidade.</p>
    </div>

    <span class="date-filter">Últimos 30 dias</span>
</div>

<div class="dashboard-layout">

    <div class="dashboard-main">

        <section class="stats-grid">

            <div class="stat-card">
                <span>Total de candidaturas</span>
                <div class="stat-value"><?= $total ?></div>
            </div>

            <div class="stat-card">
                <span>Aplicadas</span>
                <div class="stat-value">
                    <?= count($columns[1]['jobs']) ?>
                </div>
            </div>

            <div class="stat-card">
                <span>Entrevistas</span>
                <div class="stat-value">
                    <?= count($columns[2]['jobs']) ?>
                </div>
            </div>

            <div class="stat-card highlight">
                <span>Ofertas</span>
                <div class="stat-value">
                    <?= count($columns[3]['jobs']) ?>
                </div>
            </div>

        </section>

        <section class="kanban-panel" id="kanban">

            <div class="panel-header">
                <h2>Acompanhamento de candidaturas</h2>
                <span class="demo-label">Dados de demonstração</span>
            </div>

            <div class="kanban-board">

                <?php foreach ($columns as $column): ?>

                    <div class="kanban-column">

                        <div class="column-header">
                            <h3><?= escapeText($column['title']) ?></h3>
                            <span><?= count($column['jobs']) ?></span>
                        </div>

                        <div class="column-content">

                            <?php foreach (array_slice($column['jobs'], 0, 3) as $job): ?>

                                <article class="job-card">

                                    <div class="job-company">
                                        <span class="company-avatar">
                                            <?= escapeText(substr($job['company'], 0, 1)) ?>
                                        </span>

                                        <div>
                                            <strong><?= escapeText($job['company']) ?></strong>
                                            <p><?= escapeText($job['role']) ?></p>
                                        </div>
                                    </div>

                                    <div class="job-tags">
                                        <?php foreach ($job['tags'] as $tag): ?>
                                            <span><?= escapeText($tag) ?></span>
                                        <?php endforeach; ?>
                                    </div>

                                </article>

                            <?php endforeach; ?>

                            <?php if (count($column['jobs']) > 3): ?>
                                <p class="more-jobs">
                                    +<?= count($column['jobs']) - 3 ?>
                                    candidaturas não exibidas
                                </p>
                            <?php endif; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </section>

    </div>

    <aside class="study-panel" id="studies">

        <div class="study-heading">
            <div>
                <span class="study-icon">✧</span>
                <h2>Área de Estudos</h2>
            </div>
            <p>Recomendações baseadas nas vagas que você acompanha.</p>
        </div>

        <section class="study-section">
            <h3>Tecnologias mais exigidas</h3>

            <?php foreach ($technologies as $tech): ?>
                <div class="technology-item">
                    <div class="technology-info">
                        <span><?= escapeText($tech['name']) ?></span>
                        <span><?= $tech['percentage'] ?>%</span>
                    </div>

                    <div class="progress-bar">
                        <div style="width: <?= $tech['percentage'] ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>

            <p class="demo-note">
                Frequências ilustrativas; serão calculadas
                com base nas vagas cadastradas.
            </p>
        </section>

        <section class="study-section">
            <h3>Sua trilha atual</h3>

            <div class="learning-path">
                <strong>Desenvolvedor Web Jr.</strong>
                <p>Progresso demonstrativo</p>
                <div class="progress-bar">
                    <div style="width: 64%"></div>
                </div>
                <small>64% concluído</small>
            </div>
        </section>

        <section class="study-section">
            <h3>Próximos conteúdos</h3>

            <div class="lesson">PHP: Fundamentos</div>
            <div class="lesson">MySQL: Relacionamentos</div>
            <div class="lesson">Construindo APIs com PHP</div>
        </section>

        <a href="index.php?page=studies" class="study-button">
            Explorar Área de Estudos
        </a>

    </aside>

</div>
