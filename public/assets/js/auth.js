(function () {
    const toggle = document.getElementById('auth-theme-toggle');
    const root = document.documentElement;

    function syncThemeButton() {
        if (!toggle) return;
        const dark = root.dataset.theme !== 'light';
        toggle.textContent = dark ? '☀' : '☾';
        toggle.setAttribute('aria-label', dark ? 'Ativar tema claro' : 'Ativar tema escuro');
        toggle.title = toggle.getAttribute('aria-label');
    }

    if (toggle) {
        toggle.addEventListener('click', () => {
            const next = root.dataset.theme === 'light' ? 'dark' : 'light';
            root.dataset.theme = next;
            try { localStorage.setItem('devtrack-theme', next); } catch (error) {}
            syncThemeButton();
        });
        syncThemeButton();
    }

    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.passwordToggle);
            if (!input) return;
            const reveal = input.type === 'password';
            input.type = reveal ? 'text' : 'password';
            button.textContent = reveal ? 'Ocultar' : 'Mostrar';
            button.setAttribute('aria-label', reveal ? 'Ocultar senha' : 'Mostrar senha');
        });
    });
})();
