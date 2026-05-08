<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">

<header class="site-header">
    <div class="container header-inner">

        <a href="/index.php" class="logo">
            <span class="logo-text">Bloop</span>
        </a>

        <button class="burger" id="burger" aria-label="Меню">&#9776;</button>

        <nav class="main-nav" id="main-nav">
            <a href="/about.php">О магазине</a>
            <a href="/catalog.php">Каталог</a>
            <a href="/promotions.php">Акции</a>
            <a href="/new-arrivals.php">Новинки</a>
            <a href="/brands.php">Бренды</a>
            <a href="/reviews.php">Отзывы</a>
            <a href="/contacts.php">Контакты</a>
        </nav>

        <div class="header-actions">
            <a href="/cart.php" class="cart-link" title="Корзина">
                <span class="cart-icon"><img src="./img/cart.png"alt=""></span>
                    <!-- <span class="cart-count" id="cart-count"></span> -->
                    <!-- <span class="cart-count cart-count--empty" id="cart-count">0</span> -->
            </a>
                <a href="/account.php" class="btn-account-user"><img src="./img/user.png" alt=""></a>
                <!-- <a href="/admin/index.php" class="btn-admin">Админ</a> -->
                <a href="/login.php" class="btn-account">Войти</a>
        </div>

    </div>
</header>