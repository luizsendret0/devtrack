<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Acesse sua conta DevTrack ou crie uma nova conta.">
    <title><?= $page === 'login' ? 'Entrar' : 'Criar conta' ?> | DevTrack</title>
    <script>
        (function () {
            let theme = 'dark';
            try { theme = localStorage.getItem('devtrack-theme') || 'dark'; } catch (e) {}
            document.documentElement.dataset.theme = theme === 'light' ? 'light' : 'dark';
        })();
    </script>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body class="auth-body">
<header class="auth-topbar">
    <a href="index.php" class="auth-brand" aria-label="DevTrack — página inicial"><span class="auth-brand-icon">&lt;/&gt;</span> Dev<span>Track</span></a>
    <div class="auth-actions">
        <a href="index.php" class="auth-home">Voltar ao início</a>
        <button class="auth-theme-toggle" type="button" id="auth-theme-toggle" aria-label="Alternar tema" title="Alternar tema">☀</button>
    </div>
</header>
<main class="auth-main">
    <section class="auth-side" aria-label="Apresentação do DevTrack">
        <span class="auth-eyebrow">SUA CARREIRA EM EVOLUÇÃO</span>
        <h1>Organize as oportunidades.<br><span>Construa o próximo passo.</span></h1>
        <p>Acompanhe candidaturas, visualize processos seletivos e prepare suas próximas habilidades em um só lugar.</p>
        <div class="auth-feature"><span class="auth-feature-icon">✓</span> Candidaturas organizadas</div>
        <div class="auth-feature"><span class="auth-feature-icon">✓</span> Evolução orientada pelas vagas</div>
        <div class="auth-feature"><span class="auth-feature-icon">✓</span> Seus dados em uma área privada</div>
        <span class="auth-version">DevTrack · v0.3.0-alpha</span>
    </section>
    <div class="auth-form-region">
