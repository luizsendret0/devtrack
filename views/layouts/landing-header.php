<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DevTrack: organize candidaturas, acompanhe processos seletivos e desenvolva habilidades com base nas vagas de tecnologia.">
    <meta name="theme-color" content="#03080e" id="landing-theme-color">
    <title>DevTrack | Organize suas candidaturas e evolua na carreira</title>
    <script>
        // Aplica o tema antes de carregar a folha de estilos para evitar flashes.
        (function () {
            var theme = 'dark';
            try {
                theme = localStorage.getItem('devtrack-theme') || 'dark';
            } catch (e) {}
            document.documentElement.setAttribute('data-theme', theme === 'light' ? 'light' : 'dark');
        })();
    </script>
    <link rel="stylesheet" href="assets/css/landing.css">
</head>
<body class="landing-body">

<!-- Ícones locais: a landing funciona sem bibliotecas externas. -->
<svg class="icon-sprite" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <symbol id="i-code" viewBox="0 0 24 24"><path d="m8 5-6 7 6 7m8-14 6 7-6 7m-3-17-2 20"/></symbol>
    <symbol id="i-arrow-right" viewBox="0 0 24 24"><path d="M5 12h14m-6-6 6 6-6 6"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><path d="m5 12 4 4L19 6"/></symbol>
    <symbol id="i-briefcase" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="14" rx="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18"/></symbol>
    <symbol id="i-chart" viewBox="0 0 24 24"><rect x="3" y="13" width="4" height="8" rx="1"/><rect x="10" y="8" width="4" height="13" rx="1"/><rect x="17" y="3" width="4" height="18" rx="1"/></symbol>
    <symbol id="i-cap" viewBox="0 0 24 24"><path d="m2 9 10-5 10 5-10 5L2 9Zm4 3v5c3 3 9 3 12 0v-5M22 9v7"/></symbol>
    <symbol id="i-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></symbol>
    <symbol id="i-moon" viewBox="0 0 24 24"><path d="M20.5 13a8.5 8.5 0 0 1-9.5-9.5A8.5 8.5 0 1 0 20.5 13Z"/></symbol>
    <symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24"><path d="M5 5l14 14M19 5 5 19"/></symbol>
    <symbol id="i-github" viewBox="0 0 24 24"><path d="M9 19c-4 1-4-2-6-2m12 4v-3.5a3 3 0 0 0-.8-2.3c2.7-.3 5.5-1.3 5.5-6A4.6 4.6 0 0 0 18.5 5 4.2 4.2 0 0 0 18.4 2s-1.1-.3-3.5 1.4a12 12 0 0 0-6.8 0C5.7 1.7 4.6 2 4.6 2A4.2 4.2 0 0 0 4.5 5 4.6 4.6 0 0 0 3.3 8.2c0 4.7 2.8 5.7 5.5 6a3 3 0 0 0-.8 2.3V21"/></symbol>
    <symbol id="i-play" viewBox="0 0 24 24"><path d="m8 5 12 7-12 7V5Z"/></symbol>
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></symbol>
    <symbol id="i-layers" viewBox="0 0 24 24"><path d="m12 2 9 5-9 5-9-5 9-5Zm-9 10 9 5 9-5M3 17l9 5 9-5"/></symbol>
    <symbol id="i-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></symbol>
</svg>

<header class="landing-header" id="inicio">
    <div class="landing-container header-content">
        <a href="index.php" class="landing-brand" aria-label="DevTrack - Página inicial">
            <svg class="icon brand-icon" aria-hidden="true"><use href="#i-code"/></svg>
            <span>Dev<span>Track</span></span>
        </a>

        <nav class="landing-nav" id="landing-nav" aria-label="Navegação principal">
            <a href="#recursos">Recursos</a>
            <a href="#como-funciona">Como funciona</a>
            <a href="#demonstracao">Demonstração</a>
            <a href="#sobre">Sobre</a>
            <div class="mobile-auth-links">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <a href="index.php?page=dashboard">Ir para o Dashboard</a>
                <?php else: ?>
                    <a href="index.php?page=login">Entrar</a>
                    <a href="index.php?page=register">Criar conta</a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="landing-header-actions">
            <button class="landing-icon-button" id="landing-theme-toggle" type="button" title="Mudar tema" aria-label="Alternar tema">
                <svg class="icon" aria-hidden="true"><use id="landing-theme-icon" href="#i-sun"/></svg>
            </button>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <a class="landing-btn landing-btn-primary header-cta" href="index.php?page=dashboard">Ir ao painel</a>
            <?php else: ?>
                <a class="landing-btn landing-btn-ghost header-signin" href="index.php?page=login">Entrar</a>
                <a class="landing-btn landing-btn-primary header-cta" href="index.php?page=register">Criar conta</a>
            <?php endif; ?>
            <button class="landing-icon-button landing-menu-toggle" type="button" id="landing-menu-toggle" aria-label="Abrir menu" aria-controls="landing-nav" aria-expanded="false">
                <svg class="icon" aria-hidden="true"><use id="landing-menu-icon" href="#i-menu"/></svg>
            </button>
        </div>
    </div>
</header>
