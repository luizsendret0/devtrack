<!DOCTYPE html>
<html lang="pt-BR">
<head>


<script>
    (function () {
        let theme = 'dark';

        try {
            theme = localStorage.getItem('devtrack-theme') || 'dark';
        } catch (error) {
            // Usa o tema padrão caso o armazenamento não esteja disponível.
        }

        document.documentElement.dataset.theme =
            theme === 'light' ? 'light' : 'dark';
    })();
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="app-shell">

    <aside class="sidebar">

        <a href="index.php?page=dashboard" class="logo">
            <span class="logo-icon">&lt;/&gt;</span>
            Dev<span>Track</span>
        </a>

        <nav class="sidebar-nav">

            <a href="index.php?page=dashboard"
               class="<?= $page === 'dashboard' ? 'active' : '' ?>">
                <span>▦</span> Dashboard
            </a>

            <a href="index.php?page=jobs"
               class="<?= $page === 'jobs' ? 'active' : '' ?>">
                <span>▣</span> Candidaturas
            </a>

            <a href="index.php?page=vacancies"
               class="<?= $page === 'vacancies' ? 'active' : '' ?>">
                <span>⌕</span> Vagas
            </a>

            <a href="index.php?page=skills"
               class="<?= $page === 'skills' ? 'active' : '' ?>">
                <span>◇</span> Habilidades
            </a>

            <a href="index.php?page=analytics"
               class="<?= $page === 'analytics' ? 'active' : '' ?>">
                <span>▥</span> Análises
            </a>

            <a href="index.php?page=goals"
               class="<?= $page === 'goals' ? 'active' : '' ?>">
                <span>◎</span> Metas
            </a>

            <div class="nav-section">APRENDIZADO</div>

            <a href="index.php?page=studies"
               class="<?= $page === 'studies' ? 'active' : '' ?>">
                <span>✧</span> Área de Estudos
            </a>

            <a href="index.php?page=trails"
               class="<?= $page === 'trails' ? 'active' : '' ?>">
                <span>▤</span> Trilhas
            </a>

            <a href="index.php?page=contents"
               class="<?= $page === 'contents' ? 'active' : '' ?>">
                <span>☷</span> Conteúdos
            </a>

            <a href="index.php?page=exercises"
               class="<?= $page === 'exercises' ? 'active' : '' ?>">
                <span>⌘</span> Exercícios
            </a>

            <div class="nav-section">SISTEMA</div>

            <a href="index.php?page=settings"
               class="<?= $page === 'settings' ? 'active' : '' ?>">
                <span>⚙</span> Configurações
            </a>

        </nav>

        <div class="sidebar-bottom">
            <strong>Seu progresso</strong>
            <p>Mantenha suas candidaturas em dia.</p>
            <div class="progress-bar">
                <div style="width: 75%"></div>
            </div>
            <small>75% da meta (exemplo)</small>
        </div>

    </aside>

    <div class="main-shell">

        

<header class="topbar">

    <div class="search-box">
        <span aria-hidden="true">⌕</span>

        <input
            type="search"
            placeholder="Buscar vagas, empresas ou tecnologias..."
            disabled
        >
    </div>

    <div class="topbar-user">

        <button
            id="theme-toggle"
            class="theme-toggle"
            type="button"
            aria-label="Ativar modo claro"
            title="Mudar tema"
        >
            <span class="theme-toggle-icon"
                  aria-hidden="true">☀</span>
        </button>

        <span class="notification" aria-hidden="true">♧</span>

        <span class="avatar">LS</span>

    </div>

</header>



        <main class="content">
