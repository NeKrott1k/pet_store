<div class="container">
    <a href="/cart" class="checkout-back">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Назад
    </a>
    <h1 class="checkout-title">Оформление заказа</h1>

    <div class="checkout-layout">
        <div>
            <?php foreach ($cart_items as $item):
                $disc  = $item['discount_percent'] > 0;
                $price = $disc ? $item['price'] * (1 - $item['discount_percent'] / 100) : $item['price'];
            ?>
            <div class="checkout-item">
                <div class="checkout-item__img">
                    <img src="<?= htmlspecialchars($item['img'] ?? '') ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.parentElement.style.background='#E8F1EC'">
                    <span class="checkout-item__qty-badge"><?= $item['quantity'] ?> шт.</span>
                </div>
                <span class="checkout-item__name"><?= htmlspecialchars($item['name']) ?></span>
                <span class="checkout-item__price"><?= number_format($price * $item['quantity'], 0, '.', ' ') ?> ₽</span>
            </div>
            <?php endforeach ?>
        </div>

        <div class="checkout-summary">
            <h3 class="checkout-summary__title">Общая сумма</h3>
            <form method="POST" action="/checkout">
                <div class="form-group" style="margin-bottom: 12px;">
                    <input type="text" name="address" class="form-input" placeholder="Адрес доставки" required>
                </div>
                <div class="checkout-summary__total">
                    <span>Итого:</span>
                    <span class="checkout-summary__total-value"><?= number_format($total, 0, '.', ' ') ?> ₽</span>
                </div>
                <button type="submit" class="btn btn--orange btn--full btn--lg">Оформить</button>
            </form>
        </div>
    </div>
</div>
