<?php
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_valid(): bool
{
    $submitted = $_POST['csrf_token'] ?? null;
    return is_string($submitted)
        && hash_equals(csrf_token(), $submitted);
}

function redirect_to(string $page): never
{
    // A função só é chamada com nomes de rotas escritos pelo desenvolvedor.
    $url = $page === 'landing' ? 'index.php' : 'index.php?page=' . rawurlencode($page);
    header('Location: ' . $url, true, 303);
    exit;
}

function form_feedback(string $page, array $errors, array $old = []): void
{
    $_SESSION['form_feedback'][$page] = ['errors' => $errors, 'old' => $old];
}

function pull_form_feedback(string $page): array
{
    $feedback = $_SESSION['form_feedback'][$page] ?? ['errors' => [], 'old' => []];
    unset($_SESSION['form_feedback'][$page]);
    return $feedback;
}
