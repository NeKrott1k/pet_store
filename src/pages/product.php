<?php
function star_svg(bool $filled): string {
    $fill = $filled ? '#C9614A' : '#D4D4D4';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 22 21" fill="'.$fill.'"><path d="M10.318 0.319C10.365 0.223 10.439 0.143 10.53 0.086C10.621 0.03 10.725 0 10.832 0C10.939 0 11.044 0.03 11.135 0.086C11.226 0.143 11.299 0.223 11.347 0.319L13.849 5.387C14.014 5.721 14.257 6.009 14.558 6.228C14.859 6.447 15.208 6.589 15.576 6.643L21.171 7.462C21.277 7.477 21.377 7.522 21.459 7.591C21.541 7.66 21.602 7.751 21.635 7.853C21.668 7.955 21.672 8.064 21.646 8.168C21.621 8.272 21.566 8.366 21.49 8.441L17.443 12.381C17.177 12.641 16.977 12.962 16.862 13.317C16.746 13.671 16.719 14.048 16.782 14.415L17.737 19.982C17.756 20.088 17.744 20.197 17.704 20.297C17.664 20.397 17.596 20.483 17.509 20.546C17.422 20.61 17.319 20.647 17.211 20.655C17.104 20.662 16.997 20.639 16.902 20.589L11.9 17.959C11.571 17.786 11.204 17.696 10.832 17.696C10.46 17.696 10.093 17.786 9.763 17.959L4.763 20.589C4.668 20.639 4.561 20.661 4.454 20.654C4.347 20.646 4.244 20.609 4.157 20.546C4.07 20.482 4.003 20.396 3.962 20.296C3.922 20.197 3.911 20.088 3.929 19.982L4.883 14.416C4.946 14.049 4.919 13.672 4.804 13.317C4.688 12.963 4.489 12.641 4.222 12.381L0.175 8.442C0.098 8.368 0.043 8.273 0.017 8.168C-0.009 8.064 -0.005 7.955 0.028 7.852C0.061 7.75 0.122 7.659 0.205 7.59C0.287 7.521 0.387 7.476 0.494 7.461L6.088 6.643C6.456 6.589 6.806 6.447 7.107 6.228C7.409 6.009 7.652 5.721 7.817 5.387L10.318 0.319Z"/></svg>';
}
?>

<div class="container product-page">
    <div class="breadcrumbs">
        <a href="/">Главная</a>
        <span class="breadcrumbs__sep">/</span>
        <a href="/catalog">Каталог</a>
        <?php if (!empty($product['category_name'])): ?>
            <span class="breadcrumbs__sep">/</span>
            <a href="/catalog?category=<?= $product['category_id'] ?>"><?= htmlspecialchars($product['category_name']) ?></a>
        <?php endif ?>
        <span class="breadcrumbs__sep">/</span>
        <span class="breadcrumbs__current"><?= htmlspecialchars($product['name']) ?></span>
    </div>

    <div class="product-layout">
        <div>
            <div class="product-img-wrap">
                <img src="<?= htmlspecialchars($product['img'] ?? '') ?>" alt="<?= htmlspecialchars($product['name']) ?>" onerror="this.parentElement.style.background='#E8F1EC'">
                <div class="product-img-badges">
                    <?php if ($disc): ?><span class="badge badge--sale">Скидка <?= $product['discount_percent'] ?>%</span><?php endif ?>
                    <?php if ($product['is_new']): ?><span class="badge badge--new">Новинка</span><?php endif ?>
                    <?php if ($product['is_popular'] && !$disc && !$product['is_new']): ?><span class="badge badge--hit">Хит</span><?php endif ?>
                </div>
            </div>
        </div>

        <div>
            <?php if (!empty($product['brand_name'])): ?>
                <p class="product-brand"><?= htmlspecialchars($product['brand_name']) ?></p>
            <?php endif ?>
            <h1 class="product-name"><?= htmlspecialchars($product['name']) ?></h1>

            <p class="product-stock">
                <?php if ($product['stock'] > 0): ?>
                    В наличии: <strong><?= $product['stock'] ?> шт.</strong>
                <?php else: ?>
                    <span style="color:#E05252;">Нет в наличии</span>
                <?php endif ?>
            </p>

            <div class="product-price-wrap">
                <span class="product-price"><?= number_format($real_price, 0, '.', ' ') ?> ₽</span>
                <?php if ($disc): ?>
                    <span class="product-price-old"><?= number_format($product['price'], 0, '.', ' ') ?> ₽</span>
                <?php endif ?>
            </div>

            <div class="product-add">
                <?php if ($product['stock'] > 0): ?>
                    <?php if ($in_cart > 0): ?>
                        <div class="qty-control" id="cart-control" data-product-id="<?= $product['id'] ?>">
                            <button class="qty-control__btn" onclick="changeProductQty(-1)">−</button>
                            <span class="qty-control__value" id="in_cart"><?= $in_cart ?></span>
                            <button class="qty-control__btn" onclick="changeProductQty(1)">+</button>
                        </div>
                    <?php else: ?>
                        <button class="btn btn--orange btn--lg" id="add-btn" data-product-id="<?= $product['id'] ?>" onclick="AddToCart(this)">В корзину</button>
                    <?php endif ?>
                <?php else: ?>
                    <button class="btn btn--outline btn--lg" disabled>Нет в наличии</button>
                <?php endif ?>
            </div>

            <?php if (!empty($product['description'])): ?>
            <div class="product-desc">
                <h3 class="product-desc__title">Описание</h3>
                <p class="product-desc__text"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>
            <?php endif ?>
        </div>
    </div>

    <div class="reviews-section">
        <h2 class="reviews-section__title">Отзывы</h2>

        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="review-form">
            <h3 class="review-form__title">Оставить отзыв</h3>
            <form method="POST" action="/src/actions/product/add_review.php" id="review-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="star-rating" id="star-rating">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="star<?= $i ?>" name="assessment" value="<?= $i ?>" <?= $i === 5 ? 'checked' : '' ?>>
                        <label for="star<?= $i ?>">★</label>
                    <?php endfor ?>
                </div>
                <div class="form-group">
                    <textarea name="comment" class="form-textarea" placeholder="Напишите ваш отзыв..." rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn--orange">Отправить</button>
            </form>
        </div>
        <?php endif ?>

        <?php if (empty($reviews)): ?>
            <div class="catalog-empty"><p>Отзывов пока нет. Будьте первым!</p></div>
        <?php else: ?>
            <?php foreach ($reviews as $r): ?>
            <div class="review-card">
                <div class="review-card__header">
                    <div class="review-card__avatar">
                        <?php if (!empty($r['user_img'])): ?>
                            <img src="<?= htmlspecialchars($r['user_img']) ?>" alt="">
                        <?php else: ?>
                            <?= mb_strtoupper(mb_substr($r['user_name'], 0, 1)) ?>
                        <?php endif ?>
                    </div>
                    <div class="review-card__meta">
                        <div style="display:flex;gap:4px;margin-bottom:2px;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?= star_svg($i <= $r['assessment']) ?>
                            <?php endfor ?>
                        </div>
                        <p class="review-card__name"><?= htmlspecialchars($r['user_name']) ?></p>
                        <p class="review-card__date"><?= date('d.m.Y', strtotime($r['created_at'])) ?></p>
                    </div>
                </div>
                <p class="review-card__text"><?= htmlspecialchars($r['comment']) ?></p>
            </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

<script>
async function AddToCart(button) {
    const fd = new FormData();
    fd.append("product_id", button.getAttribute("data-product-id"));
    button.disabled = true;
    try {
        const res  = await fetch("/src/actions/product/add_to_cart.php", { method: "POST", body: fd });
        const data = await res.json();
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (data.success) {
            const pid = button.dataset.productId;
            button.outerHTML = `<div class="qty-control" id="cart-control" data-product-id="${pid}">
                <button class="qty-control__btn" onclick="changeProductQty(-1)">−</button>
                <span class="qty-control__value" id="in_cart">1</span>
                <button class="qty-control__btn" onclick="changeProductQty(1)">+</button>
            </div>`;
        }
    } catch(e) { console.error(e); }
    button.disabled = false;
}

async function changeProductQty(delta) {
    const ctrl = document.getElementById('cart-control');
    const span = document.getElementById('in_cart');
    const next = parseInt(span.textContent) + delta;
    if (next < 0) return;
    const fd = new FormData();
    fd.append("product_id", ctrl.dataset.productId);
    fd.append("quantity", next);
    try {
        await fetch("/src/actions/product/add_to_cart.php", { method: "POST", body: fd });
        span.textContent = next;
    } catch(e) { console.error(e); }
}
</script>
