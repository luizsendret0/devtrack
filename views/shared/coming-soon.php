
<?php

$titles = [
    'jobs' => 'Candidaturas',
    'vacancies' => 'Vagas',
    'skills' => 'Habilidades',
    'analytics' => 'Análises',
    'goals' => 'Metas',
    'studies' => 'Área de Estudos',
    'trails' => 'Trilhas de Aprendizado',
    'contents' => 'Conteúdos',
    'exercises' => 'Exercícios',
    'settings' => 'Configurações'
];

$title = $titles[$page] ?? 'Em desenvolvimento';

?>

<section class="coming-soon">
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

    <p>Esta funcionalidade está em desenvolvimento.</p>

    <a href="index.php?page=dashboard">
        Voltar ao Dashboard
    </a>
</section>

<style>
.coming-soon {
    max-width: 600px;
    margin: 80px auto;
    padding: 35px;
    background: #0a2b32;
    border: 1px solid #1d4b52;
    border-radius: 15px;
    text-align: center;
}

.coming-soon h1 {
    margin-bottom: 15px;
}

.coming-soon p {
    color: #9bb2b8;
    margin-bottom: 25px;
}

.coming-soon a {
    color: #36edba;
    text-decoration: none;
}
</style>
