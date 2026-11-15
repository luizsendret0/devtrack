<section class="auth-card" aria-labelledby="auth-title">
    <div class="auth-card-heading">
        <span class="auth-card-tag">BEM-VINDO DE VOLTA</span>
        <h2 id="auth-title">Entrar na sua conta</h2>
        <p>Continue acompanhando suas oportunidades.</p>
    </div>

    <?php if (!empty($feedback['errors'])): ?>
        <div class="auth-alert" role="alert">
            <?php foreach ($feedback['errors'] as $error): ?>
                <p><?= e($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=login" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

        <label for="login-email">E-mail</label>
        <input id="login-email" type="email" name="email" autocomplete="username" inputmode="email" maxlength="255" placeholder="seuemail@exemplo.com" value="<?= e($feedback['old']['email'] ?? '') ?>" required>

        <label for="login-password">Senha</label>
        <div class="auth-password-row">
            <input id="login-password" type="password" name="password" autocomplete="current-password" placeholder="Digite sua senha" required>
            <button type="button" class="auth-password-toggle" data-password-toggle="login-password" aria-label="Mostrar senha">Mostrar</button>
        </div>

        <button type="submit" class="auth-submit">Entrar <span aria-hidden="true">→</span></button>
    </form>

    <p class="auth-switch">Não tem uma conta? <a href="index.php?page=register">Criar conta</a></p>
</section>
