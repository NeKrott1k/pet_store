<div class="auth-page">
    <div class="auth-page__left">
        <a href="/" class="auth-page__logo">Bloop</a>
        <div class="auth-page__body">
            <h1 class="auth-page__title">Подтвердите почту</h1>
            <p class="auth-page__sub">
                Мы отправили письмо с кодом на <strong><?= htmlspecialchars($email) ?></strong>.<br>
                Не забудьте проверить папку «Спам».
            </p>

            <?php if (!empty($input_error['verify_code'])): ?>
                <div class="auth-form__error"><?= htmlspecialchars($input_error['verify_code']) ?></div>
            <?php endif ?>

            <form class="auth-form" action="/<?= $from ?>" method="POST" id="verify-form">
                <input type="hidden" name="verify_code" id="verify_code_input">
                <div class="verify-boxes">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <input type="text" class="verify-box" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                    <?php endfor ?>
                </div>
                <button type="submit" class="btn btn--orange btn--full btn--lg" style="margin-top:16px;">Подтвердить</button>
            </form>

            <p class="auth-page__footer" style="margin-top: 20px;">
                <a href="<?= $from === 'login' ? '/login' : '/register' ?>">← Назад</a>
            </p>
        </div>
    </div>
    <div class="auth-page__right">
        <img src="https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=800&fit=crop&q=80" alt="">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const boxes  = document.querySelectorAll('.verify-box');
    const hidden = document.getElementById('verify_code_input');
    const form   = document.getElementById('verify-form');

    boxes.forEach((box, i) => {
        box.addEventListener('input', () => {
            if (box.value.length === 1 && i < boxes.length - 1) boxes[i + 1].focus();
        });
        box.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
        });
        box.addEventListener('paste', e => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            [...text].forEach((ch, j) => { if (boxes[i + j]) boxes[i + j].value = ch; });
            if (boxes[i + text.length]) boxes[i + text.length].focus();
        });
    });

    form.addEventListener('submit', () => {
        hidden.value = [...boxes].map(b => b.value).join('');
    });

    if (boxes[0]) boxes[0].focus();
});
</script>
