(() => {
    const menu = document.getElementById('profile-menu');
    if (!menu) return;

    const trigger = document.getElementById('profile-menu-trigger');
    const dropdown = document.getElementById('profile-dropdown');
    const photoInput = document.getElementById('profile-avatar-file');
    const form = document.getElementById('profile-avatar-form');

    function setOpen(open) {
        dropdown.hidden = !open;
        trigger.setAttribute('aria-expanded', String(open));
    }

    trigger.addEventListener('click', () => setOpen(dropdown.hidden));
    document.addEventListener('click', event => {
        if (!menu.contains(event.target)) setOpen(false);
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !dropdown.hidden) {
            setOpen(false);
            trigger.focus();
        }
    });

    photoInput?.addEventListener('change', () => {
        const file = photoInput.files?.[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Escolha uma foto de até 2 MB.');
            photoInput.value = '';
            return;
        }
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            alert('Escolha uma imagem JPG, PNG ou WebP.');
            photoInput.value = '';
            return;
        }
        form.requestSubmit();
    });
})();
