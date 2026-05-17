<header class="header">
    <div class="header__inner">
        <a href="/" class="header__logo">Bloop</a>

        <nav class="header__nav">
            <a href="/" class="<?= $url === '' ? 'active' : '' ?>">О магазине</a>
            <a href="/catalog" class="<?= $url === 'catalog' ? 'active' : '' ?>">Каталог</a>
            <a href="/promotions" class="<?= $url === 'promotions' ? 'active' : '' ?>">Акции</a>
            <a href="/new-products" class="<?= $url === 'new-products' ? 'active' : '' ?>">Новинки</a>
            <a href="/brands" class="<?= $url === 'brands' ? 'active' : '' ?>">Бренды</a>
            <a href="/reviews" class="<?= $url === 'reviews' ? 'active' : '' ?>">Отзывы</a>
            <a href="/contacts" class="<?= $url === 'contacts' ? 'active' : '' ?>">Контакты</a>
        </nav>

        <div class="header__actions">
            <a href="<?= isset($_SESSION['user_id']) ? '/profile' : '/login' ?>" class="header__icon" title="Профиль">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </a>

            <a href="/cart" class="header__icon" title="Корзина">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                </svg>
                <?php if (isset($_SESSION["user_id"]) && $cart_count > 0): ?>
                    <span class="header__cart-badge"><?= $cart_count ?></span>
                <?php endif ?>
            </a>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="/login" class="btn btn--primary btn--sm">Войти</a>
            <?php else: ?>
                <a href="/profile" class="btn btn--outline btn--sm">
                    <?php if (!empty($_SESSION['user_avatar'])): ?>
                        <img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>" style="width:20px;height:20px;border-radius:50%;object-fit:cover;" alt="">
                    <?php endif ?>
                    Профиль
                </a>
            <?php endif ?>
        </div>
    </div>
</header>
