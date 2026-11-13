
const themeToggle = document.getElementById('theme-toggle');

function updateThemeButton() {
    if (!themeToggle) return;

    const isDark =
        document.documentElement.dataset.theme !== 'light';

    const icon = themeToggle.querySelector('.theme-toggle-icon');

    // Mostra o ícone do tema para o qual podemos mudar.
    icon.textContent = isDark ? '☀' : '☾';

    const label = isDark
        ? 'Ativar modo claro'
        : 'Ativar modo escuro';

    themeToggle.setAttribute('aria-label', label);
    themeToggle.setAttribute('title', label);
    themeToggle.setAttribute('aria-pressed', String(!isDark));
}

function toggleTheme() {
    const currentTheme = document.documentElement.dataset.theme;

    const newTheme = currentTheme === 'dark'
        ? 'light'
        : 'dark';

    document.documentElement.dataset.theme = newTheme;

    try {
        localStorage.setItem('devtrack-theme', newTheme);
    } catch (error) {
        // O botão continua funcionando mesmo sem armazenamento.
    }

    updateThemeButton();
}

if (themeToggle) {
    themeToggle.addEventListener('click', toggleTheme);
    updateThemeButton();
}
