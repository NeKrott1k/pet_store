<div class="auth-page">
    <div class="auth-page__left">
        <a href="/" class="auth-page__logo">Bloop</a>
        <div class="auth-page__body">
            <h1 class="auth-page__title">Создать аккаунт</h1>

            <?php if (!empty($input_error['general'])): ?>
                <div class="auth-form__error"><?= htmlspecialchars($input_error['general']) ?></div>
            <?php endif ?>

            <form class="auth-form" action="/register" method="POST">
                <div class="form-group">
                    <input type="text" name="name" class="form-input <?= isset($input_error['name']) ? 'error' : '' ?>"
                           placeholder="Имя" value="<?= htmlspecialchars($old_input['name'] ?? '') ?>">
                    <?php if (isset($input_error['name'])): ?>
                        <span class="form-error"><?= htmlspecialchars($input_error['name']) ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-input <?= isset($input_error['email']) ? 'error' : '' ?>"
                           placeholder="Почта" value="<?= htmlspecialchars($old_input['email'] ?? '') ?>">
                    <?php if (isset($input_error['email'])): ?>
                        <span class="form-error"><?= htmlspecialchars($input_error['email']) ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <input type="tel" name="phone" id="phone" class="form-input <?= isset($input_error['phone']) ? 'error' : '' ?>"
                           placeholder="+7 (999) 000-00-00" value="<?= htmlspecialchars($old_input['phone'] ?? '') ?>">
                    <?php if (isset($input_error['phone'])): ?>
                        <span class="form-error"><?= htmlspecialchars($input_error['phone']) ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <div class="form-input-wrap">
                        <input type="password" name="password" id="pwd1" class="form-input <?= isset($input_error['password']) ? 'error' : '' ?>" placeholder="Пароль">
                        <button type="button" class="form-input-icon" onclick="togglePwd('pwd1')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    <?php if (isset($input_error['password'])): ?>
                        <span class="form-error"><?= htmlspecialchars($input_error['password']) ?></span>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <div class="form-input-wrap">
                        <input type="password" name="confirm_password" id="pwd2" class="form-input <?= isset($input_error['confirm_password']) ? 'error' : '' ?>" placeholder="Повторите пароль">
                        <button type="button" class="form-input-icon" onclick="togglePwd('pwd2')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                    </div>
                    <?php if (isset($input_error['confirm_password'])): ?>
                        <span class="form-error"><?= htmlspecialchars($input_error['confirm_password']) ?></span>
                    <?php endif ?>
                </div>

                <button type="submit" class="btn btn--orange btn--full btn--lg">Создать аккаунт</button>
            </form>

            <p class="auth-page__footer">Уже есть аккаунт? <a href="/login">Войти</a></p>
        </div>
    </div>
    <div class="auth-page__right">
        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=800&fit=crop&q=80" alt="">
    </div>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const phone = document.getElementById('phone');
    if (phone) IMask(phone, { mask: '+{7} (000) 000-00-00' });
});
function togglePwd(id) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
}
</script>
