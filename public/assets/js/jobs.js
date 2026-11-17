// Exige uma confirmação antes de excluir definitivamente a candidatura.
document.querySelectorAll('.jobs-delete-form').forEach(form => {
    form.addEventListener('submit', event => {
        if (!window.confirm('Tem certeza que deseja excluir esta candidatura?')) {
            event.preventDefault();
        }
    });
});
