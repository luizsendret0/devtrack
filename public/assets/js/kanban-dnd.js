/** DevTrack - Kanban interativo (v0.5.1-beta)
 * Arrastar e soltar ou selecionar manualmente uma etapa.
 * A alteração só é definitiva após confirmação do servidor.
 */
(() => {
    'use strict';

    const board = document.querySelector('.dashboard-live-kanban');
    if (!board) return;

    const feedback = document.querySelector('#kanban-feedback');
    const closeDialog = document.querySelector('#kanban-close-dialog');
    const csrfToken = board.dataset.csrfToken || '';
    const validStages = new Set(['salva', 'candidatado', 'entrevista', 'aprovado', 'recusado', 'desistiu']);
    let activeCard = null;
    let saving = false;

    function message(text, isError = false) {
        if (!feedback) return;
        feedback.textContent = text;
        feedback.classList.toggle('is-error', isError);
    }

    function clearDropTargets() {
        board.querySelectorAll('.kanban-column.is-drop-target').forEach(
            column => column.classList.remove('is-drop-target')
        );
    }

    function chooseClosedStatus() {
        // A coluna Encerradas agrupa duas situações diferentes no banco.
        if (!closeDialog || typeof closeDialog.showModal !== 'function') {
            const selected = window.prompt('Encerrar como: 1 = Recusada; 2 = Desisti da vaga.');
            return Promise.resolve(selected === '1' ? 'recusado' : selected === '2' ? 'desistiu' : null);
        }

        return new Promise(resolve => {
            let finished = false;

            const finish = selected => {
                if (finished) return;
                finished = true;
                closeDialog.removeEventListener('click', onClick);
                closeDialog.removeEventListener('cancel', onCancel);
                if (closeDialog.open) closeDialog.close();
                resolve(selected);
            };
            const onClick = event => {
                const button = event.target.closest('button[data-closed-status]');
                if (button) finish(button.dataset.closedStatus || null);
            };
            const onCancel = event => {
                event.preventDefault();
                finish(null);
            };

            closeDialog.addEventListener('click', onClick);
            closeDialog.addEventListener('cancel', onCancel);
            closeDialog.showModal();
        });
    }

    async function saveStatus(card, newStatus) {
        if (saving || !card || !validStages.has(newStatus)) return;
        if (newStatus === card.dataset.currentStatus) return;

        saving = true;
        card.classList.add('is-saving');
        message('Salvando alteração...');

        const body = new FormData();
        body.append('status', newStatus);
        body.append('csrf_token', csrfToken);
        const id = card.dataset.jobId;

        try {
            const response = await fetch(`index.php?page=jobs&action=status-ajax&id=${encodeURIComponent(id)}`, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json' },
                body,
            });
            const result = await response.json().catch(() => null);
            if (!response.ok || result?.success !== true) {
                throw new Error(result?.message || 'Não foi possível atualizar a candidatura.');
            }

            // Recarregar mantém os totais e todas as colunas sincronizados com o MySQL.
            window.location.reload();
        } catch (error) {
            message(error.message || 'Erro ao salvar. Tente novamente.', true);
            card.classList.remove('is-saving');
            saving = false;
        }
    }

    board.addEventListener('dragstart', event => {
        if (saving || event.target.closest('details, button, select, input')) {
            event.preventDefault();
            return;
        }
        const card = event.target.closest('.job-card[data-job-id]');
        if (!card || !event.dataTransfer) return;

        activeCard = card;
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/plain', card.dataset.jobId);
        requestAnimationFrame(() => card.classList.add('is-dragging'));
    });

    board.addEventListener('dragend', () => {
        activeCard?.classList.remove('is-dragging');
        activeCard = null;
        clearDropTargets();
    });

    board.addEventListener('dragover', event => {
        if (!activeCard || saving) return;
        const column = event.target.closest('.kanban-column[data-stage]');
        if (!column) return;
        event.preventDefault();
        if (event.dataTransfer) event.dataTransfer.dropEffect = 'move';
        clearDropTargets();
        column.classList.add('is-drop-target');
    });

    board.addEventListener('dragleave', event => {
        const column = event.target.closest('.kanban-column[data-stage]');
        if (column && !column.contains(event.relatedTarget)) {
            column.classList.remove('is-drop-target');
        }
    });

    board.addEventListener('drop', async event => {
        if (!activeCard || saving) return;
        const column = event.target.closest('.kanban-column[data-stage]');
        if (!column) return;
        event.preventDefault();
        clearDropTargets();

        const card = activeCard;
        const destination = column.dataset.stage;
        const original = card.dataset.currentStatus;

        if (destination === original) return;
        if (destination === 'encerradas' && ['recusado', 'desistiu'].includes(original)) return;

        const nextStatus = destination === 'encerradas'
            ? await chooseClosedStatus()
            : destination;

        if (nextStatus) await saveStatus(card, nextStatus);
    });

    // Alternativa para celular, teclado e browsers sem suporte a drag-and-drop.
    board.querySelectorAll('.kanban-status-form').forEach(form => {
        form.addEventListener('submit', async event => {
            if (saving) {
                event.preventDefault();
                return;
            }
            const card = form.closest('.job-card[data-job-id]');
            const select = form.querySelector('select[name="status"]');
            if (!card || !select) return;
            event.preventDefault();
            await saveStatus(card, select.value);
        });
    });
})();
