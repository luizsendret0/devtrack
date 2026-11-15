<?php
// Este componente só deve ser incluído em páginas autenticadas.
if (!empty($_SESSION['user_id'])):
    $profileName = (string) ($_SESSION['user_name'] ?? 'Usuário');
    $profileParts = preg_split('/\s+/u', trim($profileName));
    $first = $profileParts[0] ?? 'U';
    $last = count($profileParts) > 1 ? end($profileParts) : '';
    $initials = strtoupper(substr($first, 0, 1) . ($last !== '' ? substr($last, 0, 1) : ''));
    $profilePhoto = null;

    // Lê a foto atual do banco para manter a imagem entre sessões diferentes.
    try {
        $profileDb = require __DIR__ . '/../../app/config/database.php';
        $photoStmt = $profileDb->prepare('SELECT avatar_path FROM users WHERE id = :id LIMIT 1');
        $photoStmt->execute(['id' => (int) $_SESSION['user_id']]);
        $photoValue = $photoStmt->fetchColumn();
        if (is_string($photoValue) && preg_match('~^uploads/avatars/[a-f0-9]{32}\.(?:jpg|png|webp)$~', $photoValue)) {
            $profilePhoto = $photoValue;
        }
    } catch (Throwable $error) {
        error_log('[DevTrack profile/menu] ' . $error->getMessage());
    }
    $profileMessage = $_SESSION['profile_flash'] ?? null;
    unset($_SESSION['profile_flash']);
?>
<div class="profile-menu" id="profile-menu">
    <button type="button" class="profile-menu-trigger" id="profile-menu-trigger"
            aria-label="Abrir menu do perfil" aria-haspopup="true"
            aria-controls="profile-dropdown"
            aria-expanded="<?= $profileMessage ? 'true' : 'false' ?>">
        <span class="profile-avatar">
            <?php if ($profilePhoto): ?>
                <img src="<?= e($profilePhoto) ?>" alt="Foto do perfil" width="40" height="40">
            <?php else: ?>
                <?= e($initials) ?>
            <?php endif; ?>
        </span>
        <svg class="profile-chevron" width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div class="profile-dropdown" id="profile-dropdown" <?= $profileMessage ? '' : 'hidden' ?>>
        <div class="profile-dropdown-user">
            <span class="profile-avatar profile-avatar-large">
                <?php if ($profilePhoto): ?>
                    <img src="<?= e($profilePhoto) ?>" alt="" width="46" height="46">
                <?php else: ?>
                    <?= e($initials) ?>
                <?php endif; ?>
            </span>
            <div>
                <strong><?= e($profileName) ?></strong>
                <small>Minha conta</small>
            </div>
        </div>

        <?php if (is_array($profileMessage)): ?>
            <p class="profile-menu-feedback <?= ($profileMessage['type'] ?? '') === 'success' ? 'is-success' : 'is-error' ?>" role="alert">
                <?= e((string) ($profileMessage['text'] ?? '')) ?>
            </p>
        <?php endif; ?>

        <form method="post" action="index.php?page=avatar-upload" enctype="multipart/form-data" id="profile-avatar-form">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <input class="profile-file-input" type="file" id="profile-avatar-file" name="avatar"
                   accept="image/jpeg,image/png,image/webp" aria-label="Selecionar foto de perfil">
            <label class="profile-menu-action" for="profile-avatar-file">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M14 4h-4l-2 3H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-4l-2-3Z"/>
                    <circle cx="12" cy="13" r="3"/>
                </svg>
                Alterar foto de perfil
            </label>
        </form>

        <div class="profile-menu-divider"></div>

        <form method="post" action="index.php?page=logout" class="profile-logout-form">
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <button type="submit" class="profile-menu-action profile-menu-logout">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <path d="m16 17 5-5-5-5M21 12H9"/>
                </svg>
                Encerrar sessão
            </button>
        </form>
    </div>
</div>
<?php endif; ?>
