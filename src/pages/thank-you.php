<div class="auth-page">
    <div class="auth-page__left">
        <a href="/" class="auth-page__logo">Bloop</a>
        <div class="auth-page__body">
            <h1 class="auth-page__title" style="color:var(--green);">Спасибо за заказ!</h1>
            <p class="auth-page__sub">
                Кто-то скоро будет очень доволен. Мы уже начали бережно собирать посылку для вашего питомца.
            </p>
            <?php if ($order_id): ?>
                <p style="font-size:.95rem; font-weight:800; margin-bottom:24px;">Номер заказа: <span style="color:var(--green);">#<?= $order_id ?></span></p>
            <?php endif ?>
            <a href="/catalog" class="btn btn--orange btn--lg">Продолжить покупки</a>
        </div>
    </div>
    <div class="auth-page__right">
        <img src="/public/assets/images/thank-you.jpg" alt="" onerror="this.parentElement.style.background='#2B5235'">
    </div>
</div>
