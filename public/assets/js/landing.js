(() => {
    'use strict';

    const root = document.documentElement;
    const themeButton = document.getElementById('landing-theme-toggle');
    const themeIcon = document.getElementById('landing-theme-icon');
    const themeMeta = document.getElementById('landing-theme-color');
    const menuButton = document.getElementById('landing-menu-toggle');
    const menuIcon = document.getElementById('landing-menu-icon');
    const nav = document.getElementById('landing-nav');

    function updateThemeButton() {
        const isDark = root.dataset.theme !== 'light';
        if (themeIcon) themeIcon.setAttribute('href', isDark ? '#i-sun' : '#i-moon');
        if (themeButton) {
            themeButton.setAttribute('aria-label', isDark ? 'Ativar modo claro' : 'Ativar modo escuro');
            themeButton.setAttribute('title', isDark ? 'Ativar modo claro' : 'Ativar modo escuro');
        }
        if (themeMeta) themeMeta.setAttribute('content', isDark ? '#03080e' : '#f8fbff');
    }

    themeButton?.addEventListener('click', () => {
        const next = root.dataset.theme === 'light' ? 'dark' : 'light';
        root.dataset.theme = next;
        try { localStorage.setItem('devtrack-theme', next); } catch (e) {}
        updateThemeButton();
    });
    updateThemeButton();

    function closeMenu() {
        nav?.classList.remove('is-open');
        menuButton?.setAttribute('aria-expanded', 'false');
        menuButton?.setAttribute('aria-label', 'Abrir menu');
        menuIcon?.setAttribute('href', '#i-menu');
    }

    menuButton?.addEventListener('click', () => {
        if (!nav) return;
        const open = nav.classList.toggle('is-open');
        menuButton.setAttribute('aria-expanded', String(open));
        menuButton.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
        menuIcon?.setAttribute('href', open ? '#i-x' : '#i-menu');
    });

    nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') closeMenu();
    });
    window.addEventListener('resize', () => {
        if (window.innerWidth > 820) closeMenu();
    });
})();
