<div class="auth-page">
    <div class="auth-page__left">
        <a href="/" class="auth-page__logo">Bloop</a>
        <div class="auth-page__body">
            <h1 class="auth-page__title">С возвращением!</h1>
            <p class="auth-page__sub">Войдите в аккаунт, чтобы продолжить покупки.</p>

            <?php if (!empty($input_error['general'])): ?>
                <div class="auth-form__error"><?= htmlspecialchars($input_error['general']) ?></div>
            <?php endif ?>

            <form class="auth-form" action="/login" method="POST">
                <div class="form-group">
                    <div class="form-input-wrap">
                        <input type="email" name="email" class="form-input <?= isset($input_error['email']) ? 'error' : '' ?>"
                               placeholder="Почта" value="<?= htmlspecialchars($old_input['email'] ?? '') ?>">
                    </div>
                    <?php if (isset($input_error['email'])): ?>
                        <span class="form-error"><?= htmlspecialchars($input_error['email']) ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <div class="form-input-wrap">
                        <input type="password" name="password" id="pwd" class="form-input <?= isset($input_error['password']) ? 'error' : '' ?>" placeholder="Пароль">
                        <button type="button" class="form-input-icon" onclick="togglePwd('pwd', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    <?php if (isset($input_error['password'])): ?>
                        <span class="form-error"><?= htmlspecialchars($input_error['password']) ?></span>
                    <?php endif ?>
                </div>

                <button type="submit" class="btn btn--orange btn--full btn--lg">Войти</button>
            </form>

            <p class="auth-page__footer">Ещё нет аккаунта? <a href="/register">Создать аккаунт</a></p>
        </div>
    </div>
    <div class="auth-page__right">
        <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=800&fit=crop&q=80" alt="">
    </div>
</div>

<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
