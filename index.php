<?php
require_once './header.php';
?>

<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/main.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">

<div class="slider" id="slider">
    <div class="slider__track" id="slider-track">
            <div class="slider__slide">
                    <img src="/assets/img/" alt="?" class="slider__img">
                    <div class="slider__placeholder"></div>
                <div class="slider__content">
                        <h2 class="slider__title"></h2>
                        <p class="slider__desc"></p>
                        <a href="" class="btn btn-accent slider__btn">
                            Подробнее →
                        </a>
                </div>
            </div>
    </div>
        <button class="slider__arrow slider__arrow--prev" id="slider-prev" aria-label="Назад">&#8592;</button>
        <button class="slider__arrow slider__arrow--next" id="slider-next" aria-label="Вперёд">&#8594;</button>
        <div class="slider__dots" id="slider-dots">
                <button class="slider__dot" data-index="" aria-label="Слайд"></button>
        </div>
</div>

<div class="hero-placeholder">
    <div class="container hero-placeholder__inner">
        <div class="hero-placeholder__content">
            <span class="section-label">Премиальный уход</span>
            <h1 class="hero-placeholder__title">Естественная забота для ваших питомцев</h1>
            <p class="hero-placeholder__desc">Только проверенные товары от ведущих производителей.</p>
            <a href="/catalog.php" class="btn btn-accent">Перейти в каталог</a>
        </div>
    </div>
</div>

<section class="info-section">
    <div class="container">
        <div class="info-section__inner">
            <div class="info-section__content">
                <span class="section-label">Премиальный уход</span>
                <h2 class="info-section__title">Естественная забота для хороших мальчиков и девочек</h2>
                <p class="info-section__desc">
                    Мы предлагаем отборный выбор проверенных товаров, эксклюзивных и доступных для вашего питомца. Только проверенные бренды. Только честные составы.
                </p>
                <a href="/catalog.php" class="btn btn-primary">Перейти в каталог</a>
                <div class="info-section__stats">
                    <div class="info-stat">
                        <span class="info-stat__value">★★★★★</span>
                        <span class="info-stat__label">средняя оценка</span>
                    </div>
                    <div class="info-stat">
                        <span class="info-stat__value">6</span>
                        <span class="info-stat__label">товаров</span>
                    </div>
                    <div class="info-stat">
                        <span class="info-stat__value">3</span>
                        <span class="info-stat__label">брендов</span>
                    </div>
                </div>
            </div>
            <div class="info-section__visual">
                <div class="info-section__img-wrap">
                    <div class="info-section__img-placeholder">🐕</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-home">
    <div class="container">
        <div class="about-home__header">
            <div class="about-home__heading">
                <span class="section-label">О магазине</span>
                <h2 class="section-title">Мы верим, что питомцы<br>заслуживают лучшего</h2>
            </div>
            <p class="about-home__desc">
                Зоомагазин — это не просто магазин. Это пространство, где каждый товар проходит тщательный отбор. Мы работаем только с теми производителями, которые разделяют нашу философию: натуральные ингредиенты, честные составы и забота о природе.
            </p>
        </div>
        <div class="about-home__features">
            <div class="feature-card">
                <div class="feature-card__icon">✦</div>
                <h3 class="feature-card__title">Премиум качество</h3>
                <p class="feature-card__desc">Каждый товар проходит многоступенчатый контроль качества. Никаких компромиссов.</p>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon">⟳</div>
                <h3 class="feature-card__title">Быстрая доставка</h3>
                <p class="feature-card__desc">Доставляем по городу за 1–2 дня, по России — за 3–7 рабочих дней.</p>
            </div>
            <div class="feature-card">
                <div class="feature-card__icon">✓</div>
                <h3 class="feature-card__title">Одобрено ветеринарами</h3>
                <p class="feature-card__desc">Весь ассортимент согласован с практикующими ветеринарами-диетологами.</p>
            </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <div class="home-section__head">
            <div>
                <span class="section-label">Популярное</span>
                <h2 class="section-title">Популярные товары</h2>
            </div>
            <a href="/catalog.php" class="home-section__more">Смотреть все →</a>
        </div>
        <div class="products-grid products-grid--2">
            <div class="product-card">
                <a href="/product.php" class="product-card__img-wrap">
                    <img src="./img/directly-shot-cat-sleeping-bed_1048944-24699247.avif" alt="">
                    <div class="product-card__badges">
                        <span class="badge badge-sale">-10%</span>
                        <span class="badge badge-hit">Хит</span>
                        <span class="badge badge-new">Новинка</span>
                    </div>
                </a>
                <div class="product-card__body">
                    <div class="product-card__brand">Royal Canin</div>
                        <a href="/product.php" class="product-card__name">Дразнилка-удочка для кошек</a>
                        <div class="product-card__price">
                            <div class="price-old">190 ₽</div>
                            <div class="price-new">171 ₽</div>
                        </div>
                    </div>
                    <div class="product-card__footer">
                        <a href="/login.php" class="btn btn-outline btn-sm" style="width:100%;text-align:center">Войти для покупки</a>
                    </div>
                </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <div class="home-section__head">
            <div>
                <span class="section-label">Акции</span>
                <h2 class="section-title">Актуальные предложения</h2>
            </div>
            <a href="/promotions.php" class="home-section__more">Все акции →</a>
        </div>
        <div class="promo-cards">
            <div class="promo-card promo-card--light">
                <div class="promo-card__body">
                    <span class="promo-card__badge">Что</span>
                    <h3 class="promo-card__title">Нечто</h3>
                    <p class="promo-card__desc">Что-то.</p>
                    <a href="/pages/product.php?id=6" class="promo-card__btn">Смотреть →</a>
                </div>
                <div class="promo-card__media">
                    <img src="./img/47e3083ea7daa1a596569d76d7f7fd8e.jpg">
                    <div class="promo-card__icon">📦</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <div class="home-section__head">
            <div>
                <span class="section-label">Отзывы</span>
                <h2 class="section-title">Что говорят владельцы</h2>
            </div>
            <a href="/reviews.php" class="home-section__more">Все отзывы →</a>
        </div>
        <div class="home-reviews">
                <div class="home-review">
                    <div class="home-review__stars">☆☆☆☆☆></div>
                        <p class="home-review__text">Что-то написано</p>
                    <div class="home-review__head">
                        <div class="home-review__avatar"></div>
                        <div>
                            <div class="home-review__author">Кто-то</div>
                            <a href="/product.php" class="home-review__product">Название чего-то</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>

<section class="contact-teaser">
    <div class="container">
        <div class="contact-teaser__inner">
            <div class="contact-teaser__info">
                <span class="section-label">Контакты</span>
                <h2 class="section-title">Остались вопросы?</h2>
                <p class="contact-teaser__desc">
                    Напишите нам — мы отвечаем в течение нескольких часов. Наши специалисты помогут подобрать идеальный рацион для вашего питомца.
                </p>
                    <div class="contact-teaser__item">
                        <div class="contact-teaser__item-icon">☎</div>
                        <div>
                            <div class="contact-teaser__item-label">Телефон</div>
                            <a href="8800-555-35-35" class="contact-teaser__item-value"></a>
                        </div>
                    </div>
                    <div class="contact-teaser__item">
                        <div class="contact-teaser__item-icon">✉</div>
                        <div>
                            <div class="contact-teaser__item-label">Email</div>
                            <a href="Почта кого-то" class="contact-teaser__item-value"></a>
                        </div>
                    </div>
            </div>
            <div class="contact-teaser__form-wrap">
                <form class="contact-teaser__form" action="/contacts.php" method="POST">
                    <div class="form-group">
                        <label for="ct-name">Ваше имя</label>
                        <input type="text" id="ct-name" name="name" class="form-control" placeholder="Иван Иванов" required>
                    </div>
                    <div class="form-group">
                        <label for="ct-email">Email</label>
                        <input type="email" id="ct-email" name="email" class="form-control" placeholder="ivan@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="ct-message">Сообщение</label>
                        <textarea id="ct-message" name="message" class="form-control" rows="4"
                                  placeholder="Расскажите о вашем питомце и задайте вопрос..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-accent" style="width:100%;">Отправить сообщение →</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
require_once './footer.php'; 
?>
