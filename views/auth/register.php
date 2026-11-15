<section class="auth-card" aria-labelledby="auth-title">
    <div class="auth-card-heading">
        <span class="auth-card-tag">COMECE AGORA</span>
        <h2 id="auth-title">Crie sua conta</h2>
        <p>Seu próximo passo na carreira começa aqui.</p>
    </div>

    <?php if (!empty($feedback['errors'])): ?>
        <div class="auth-alert" role="alert">
            <?php foreach ($feedback['errors'] as $error): ?>
                <p><?= e($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=register" class="auth-form">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

        <label for="register-name">Nome</label>
        <input id="register-name" type="text" name="name" autocomplete="name" maxlength="150" placeholder="Como podemos te chamar?" value="<?= e($feedback['old']['name'] ?? '') ?>" required>

        <label for="register-email">E-mail</label>
        <input id="register-email" type="email" name="email" autocomplete="username" maxlength="255" placeholder="seuemail@exemplo.com" value="<?= e($feedback['old']['email'] ?? '') ?>" required>

        <label for="register-password">Senha <span class="auth-hint">(mínimo 8 caracteres)</span></label>
        <div class="auth-password-row">
            <input id="register-password" type="password" name="password" autocomplete="new-password" minlength="8" placeholder="Crie uma senha" required>
            <button type="button" class="auth-password-toggle" data-password-toggle="register-password" aria-label="Mostrar senha">Mostrar</button>
        </div>

        <label for="register-confirmation">Confirmar senha</label>
        <div class="auth-password-row">
            <input id="register-confirmation" type="password" name="password_confirmation" autocomplete="new-password" minlength="8" placeholder="Repita sua senha" required>
            <button type="button" class="auth-password-toggle" data-password-toggle="register-confirmation" aria-label="Mostrar senha">Mostrar</button>
        </div>

        <button type="submit" class="auth-submit">Criar conta <span aria-hidden="true">→</span></button>
    </form>

    <p class="auth-switch">Já tem uma conta? <a href="index.php?page=login">Entrar</a></p>
</section>
