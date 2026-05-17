<?php
function render_stars(int $n): string {
    $out = '<div class="stars">';
    for ($i = 1; $i <= 5; $i++) {
        $fill = $i <= $n ? '#C9614A' : '#D4D4D4';
        $out .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 22 21" fill="' . $fill . '"><path d="M10.318 0.319C10.365 0.223 10.439 0.143 10.53 0.086C10.621 0.03 10.725 0 10.832 0C10.939 0 11.044 0.03 11.135 0.086C11.226 0.143 11.299 0.223 11.347 0.319L13.849 5.387C14.014 5.721 14.257 6.009 14.558 6.228C14.859 6.447 15.208 6.589 15.576 6.643L21.171 7.462C21.277 7.477 21.377 7.522 21.459 7.591C21.541 7.66 21.602 7.751 21.635 7.853C21.668 7.955 21.672 8.064 21.646 8.168C21.621 8.272 21.566 8.366 21.49 8.441L17.443 12.381C17.177 12.641 16.977 12.962 16.862 13.317C16.746 13.671 16.719 14.048 16.782 14.415L17.737 19.982C17.756 20.088 17.744 20.197 17.704 20.297C17.664 20.397 17.596 20.483 17.509 20.546C17.422 20.61 17.319 20.647 17.211 20.655C17.104 20.662 16.997 20.639 16.902 20.589L11.9 17.959C11.571 17.786 11.204 17.696 10.832 17.696C10.46 17.696 10.093 17.786 9.763 17.959L4.763 20.589C4.668 20.639 4.561 20.661 4.454 20.654C4.347 20.646 4.244 20.609 4.157 20.546C4.07 20.482 4.003 20.396 3.962 20.296C3.922 20.197 3.911 20.088 3.929 19.982L4.883 14.416C4.946 14.049 4.919 13.672 4.804 13.317C4.688 12.963 4.489 12.641 4.222 12.381L0.175 8.442C0.098 8.368 0.043 8.273 0.017 8.168C-0.009 8.064 -0.005 7.955 0.028 7.852C0.061 7.75 0.122 7.659 0.205 7.59C0.287 7.521 0.387 7.476 0.494 7.461L6.088 6.643C6.456 6.589 6.806 6.447 7.107 6.228C7.409 6.009 7.652 5.721 7.817 5.387L10.318 0.319Z"/></svg>';
    }
    $out .= '</div>';
    return $out;
}

function get_badge(array $p): string {
    if ($p['discount_percent'] > 0) return '<span class="badge badge--sale">Скидка ' . $p['discount_percent'] . '%</span>';
    if ($p['is_new'] ?? false) return '<span class="badge badge--new">Новинка</span>';
    if ($p['is_popular'] ?? false) return '<span class="badge badge--hit">Хит</span>';
    return '';
}
?>

<!-- HERO -->
<div class="container">
    <section class="hero" style="background-image:url('https://images.unsplash.com/photo-1601758003122-53c40e686a19?w=1400&fit=crop&q=80');">
        <div class="hero__content">
            <p class="hero__label">Специальное предложение</p>
            <h1 class="hero__title">Скидка 20% на весь премиум уход</h1>
            <a href="/promotions" class="btn btn--orange">Подробнее</a>
        </div>
        <div class="hero__cards">
            <a href="/catalog" class="hero-card">
                <div class="hero-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </div>
                <span class="hero-card__text">Полезная еда<br>для питомцев</span>
            </a>
            <a href="/catalog" class="hero-card">
                <div class="hero-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                </div>
                <span class="hero-card__text">Выбор<br>покупателей</span>
            </a>
        </div>
    </section>
</div>

<!-- ABOUT -->
<section class="section">
    <div class="container">
        <div class="about-section">
            <div>
                <p class="about-section__eyebrow">О нас</p>
                <h2 class="about-section__title">Естественная забота для хороших мальчиков и девочек</h2>
                <p class="about-section__text">Bloop — это тщательный выбор премиальных товаров для ваших питомцев. Мы сотрудничаем только с проверенными брендами и заботимся о здоровье и счастье вашего питомца.</p>
                <div class="about-section__stats">
                    <div class="stat">
                        <span class="stat__value">4.8</span>
                        <span class="stat__label">Рейтинг</span>
                    </div>
                    <div class="stat">
                        <span class="stat__value">12 000+</span>
                        <span class="stat__label">Довольных клиентов</span>
                    </div>
                    <div class="stat">
                        <span class="stat__value">300+</span>
                        <span class="stat__label">Товаров</span>
                    </div>
                </div>
            </div>
            <div class="about-section__img">
                <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=600&h=750&fit=crop&q=80" alt="Питомец">
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="section" style="padding-top: 0;">
    <div class="container">
        <h2 class="section-title" style="text-align:center; margin-bottom: 40px;">Мы верим, что питомцы заслуживают лучшего</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="feature-card__title">Прямые качества</h3>
                <p class="feature-card__text">Только проверенные поставщики и сертифицированная продукция для вашего питомца.</p>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                </div>
                <h3 class="feature-card__title">Быстрая доставка</h3>
                <p class="feature-card__text">Доставляем по всей России. Оформите заказ сегодня — получите уже завтра.</p>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"/></svg>
                </div>
                <h3 class="feature-card__title">Проверено ветеринарами</h3>
                <p class="feature-card__text">Каждый продукт в нашем каталоге одобрен ветеринарными специалистами.</p>
            </div>
        </div>
    </div>
</section>

<!-- POPULAR PRODUCTS -->
<?php if (!empty($popular)): ?>
<section class="section" style="padding-top: 0;">
    <div class="container">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom: 24px;">
            <h2 class="section-title" style="margin-bottom:0;">Популярные товары</h2>
            <a href="/catalog" class="btn btn--outline btn--sm">Все товары</a>
        </div>
        <div class="cards-row">
            <?php foreach ($popular as $p): ?>
            <a href="/product/<?= $p['id'] ?>" class="card">
                <div class="card__img-wrap">
                    <img src="<?= htmlspecialchars($p['img'] ?? '') ?>" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.parentElement.style.background='#E8F1EC'">
                    <div class="card__badges"><?= get_badge($p) ?></div>
                </div>
                <div class="card__body">
                    <p class="card__name"><?= htmlspecialchars($p['name']) ?></p>
                    <div class="card__footer">
                        <div>
                            <?php if ($p['discount_percent'] > 0): ?>
                                <span class="card__price card__price-new"><?= number_format($p['price'] * (1 - $p['discount_percent'] / 100), 0, '.', ' ') ?> ₽</span>
                                <span class="card__price-old"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</span>
                            <?php else: ?>
                                <span class="card__price"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</span>
                            <?php endif ?>
                        </div>
                        <button class="btn btn--orange btn--sm" onclick="event.preventDefault(); AddToCart(this)" data-product-id="<?= $p['id'] ?>">В корзину</button>
                    </div>
                </div>
            </a>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>

<!-- PROMOS -->
<section class="section" style="padding-top: 0;">
    <div class="container">
        <h2 class="section-title" style="margin-bottom: 24px;">Актуальные предложения</h2>
        <div class="promos-grid">
            <div class="promo-banner promo-banner--green">
                <div>
                    <p class="promo-banner__label">Акция</p>
                    <h3 class="promo-banner__title">Скидка 20% на премиум корм</h3>
                    <p class="promo-banner__sub">Только до конца месяца</p>
                </div>
                <a href="/promotions" class="btn btn--orange btn--sm" style="align-self:flex-start;">Подробнее</a>
            </div>
            <div class="promo-banner promo-banner--orange">
                <div>
                    <p class="promo-banner__label">Доставка</p>
                    <h3 class="promo-banner__title">Бесплатная доставка от 3 000 ₽</h3>
                    <p class="promo-banner__sub">По всей России</p>
                </div>
                <a href="/catalog" class="btn btn--primary btn--sm" style="align-self:flex-start; background:rgba(255,255,255,0.2); border-color:rgba(255,255,255,0.4); color:#fff;">В каталог</a>
            </div>
        </div>
    </div>
</section>

<!-- REVIEWS -->
<?php if (!empty($home_reviews)): ?>
<section class="section" style="padding-top: 0;">
    <div class="container">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom: 24px;">
            <h2 class="section-title" style="margin-bottom:0;">Что говорят владельцы</h2>
            <a href="/reviews" class="btn btn--outline btn--sm">Все отзывы</a>
        </div>
        <div class="main-reviews">
            <?php foreach ($home_reviews as $r): ?>
            <div class="main-review-card">
                <?= render_stars((int)$r['assessment']) ?>
                <p class="main-review-card__text">"<?= htmlspecialchars($r['comment']) ?>"</p>
                <div class="main-review-card__author">
                    <div class="main-review-card__avatar">
                        <?php if (!empty($r['user_img'])): ?>
                            <img src="<?= htmlspecialchars($r['user_img']) ?>" alt="">
                        <?php else: ?>
                            <?= mb_strtoupper(mb_substr($r['user_name'], 0, 1)) ?>
                        <?php endif ?>
                    </div>
                    <span class="main-review-card__name"><?= htmlspecialchars($r['user_name']) ?></span>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>

<!-- CONTACTS SECTION -->
<section class="section" style="padding-top: 0; padding-bottom: 0;">
    <div class="container">
        <div class="contacts-section">
            <div>
                <h2 class="contacts-section__title">Остались вопросы?</h2>
                <p class="contacts-section__sub">Напишите нам — мы ответим в течение нескольких часов.</p>
                <div class="contacts-section__items">
                    <div class="contacts-section__item">
                        <div class="contacts-section__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </div>
                        <div class="contacts-section__info">
                            <strong>Телефон</strong>
                            <span>+7 (495) 000-00-00</span>
                        </div>
                    </div>
                    <div class="contacts-section__item">
                        <div class="contacts-section__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div class="contacts-section__info">
                            <strong>Email</strong>
                            <span>hello@bloop.ru</span>
                        </div>
                    </div>
                </div>
            </div>
            <form class="contact-form" action="/contacts" method="GET">
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Ваше имя">
                </div>
                <div class="form-group">
                    <input type="email" class="form-input" placeholder="Email">
                </div>
                <div class="form-group">
                    <textarea class="form-textarea" placeholder="Сообщение" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn--orange btn--full">Отправить сообщение</button>
            </form>
        </div>
    </div>
</section>

<script>
async function AddToCart(button) {
    const formdata = new FormData();
    formdata.append("product_id", button.getAttribute("data-product-id"));
    button.disabled = true;
    try {
        const result = await fetch("/src/actions/product/add_to_cart.php", { method: "POST", body: formdata });
        const data = await result.json();
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (data.success) {
            const badge = document.querySelector('.header__cart-badge');
            if (badge) badge.textContent = parseInt(badge.textContent || '0') + 1;
        }
    } catch(e) { console.error(e); }
    button.disabled = false;
}
</script>
