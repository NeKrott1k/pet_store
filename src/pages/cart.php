<?php
function morph(int $n, array $forms): string {
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $forms[2];
    if ($n1 > 1 && $n1 < 5)  return $forms[1];
    if ($n1 === 1)            return $forms[0];
    return $forms[2];
}
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">Корзина <?php if (!empty($cart_items)): ?><span style="font-size:1rem;font-weight:600;color:var(--text-light);"><?= count($cart_items) ?> <?= morph(count($cart_items), ['товар','товара','товаров']) ?></span><?php endif ?></h1>
    </div>

    <?php if (empty($cart_items)): ?>
        <div class="cart-empty">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
            <h2>Корзина пуста</h2>
            <p>Добавьте товары из каталога, чтобы оформить заказ.</p>
            <a href="/catalog" class="btn btn--primary">Перейти в каталог</a>
        </div>
    <?php else: ?>
        <div class="cart-layout">
            <div>
                <div class="cart-header-row">
                    <input type="checkbox" id="check-all" style="width:18px;height:18px;accent-color:var(--orange);" checked>
                    <label for="check-all" style="font-size:.875rem;font-weight:600;cursor:pointer;">Все</label>
                </div>
                <div class="cart-list" id="cart-list">
                    <?php foreach ($cart_items as $item):
                        $disc   = $item['discount_percent'] > 0;
                        $price  = $disc ? $item['price'] * (1 - $item['discount_percent'] / 100) : $item['price'];
                    ?>
                    <div class="cart-item" data-id="<?= $item['product_id'] ?>">
                        <div class="cart-item__check">
                            <input type="checkbox" class="item-check" checked style="width:18px;height:18px;accent-color:var(--orange);">
                        </div>
                        <div class="cart-item__img">
                            <img src="<?= htmlspecialchars($item['img'] ?? '') ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.parentElement.style.background='#E8F1EC'">
                        </div>
                        <div class="cart-item__info">
                            <a href="/product/<?= $item['product_id'] ?>" class="cart-item__name"><?= htmlspecialchars($item['name']) ?></a>
                            <?php if ($item['badge_type'] === 'hit'): ?>
                                <div class="cart-item__badge"><span class="badge badge--hit">Хит</span></div>
                            <?php elseif ($item['badge_type'] === 'new'): ?>
                                <div class="cart-item__badge"><span class="badge badge--new">Новинка</span></div>
                            <?php endif ?>
                            <?php if ($disc): ?>
                                <div class="cart-item__badge"><span class="badge badge--sale">Скидка <?= $item['discount_percent'] ?>%</span></div>
                            <?php endif ?>
                            <div>
                                <span class="cart-item__price <?= $disc ? 'cart-item__price-new' : '' ?>"><?= number_format($price, 0, '.', ' ') ?> ₽</span>
                                <?php if ($disc): ?>
                                    <span class="cart-item__price-old"><?= number_format($item['price'], 0, '.', ' ') ?> ₽</span>
                                <?php endif ?>
                            </div>
                            <?php if ($item['stock'] <= 3 && $item['stock'] > 0): ?>
                                <div class="cart-item__extra">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                                    Осталось <?= $item['stock'] ?> шт.
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="cart-item__right">
                            <div class="qty-control" data-product-id="<?= $item['product_id'] ?>">
                                <button class="qty-control__btn" onclick="changeCartQty(this, -1)">−</button>
                                <span class="qty-control__value"><?= $item['quantity'] ?></span>
                                <button class="qty-control__btn" onclick="changeCartQty(this, 1)">+</button>
                            </div>
                            <button class="cart-item__delete" onclick="removeFromCart(this, <?= $item['product_id'] ?>)" title="Удалить">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="cart-summary">
                <h3 class="cart-summary__title">Общая сумма</h3>
                <div class="cart-summary__rows">
                    <div class="cart-summary__row">
                        <span>Товары, <?= count($cart_items) ?> шт.</span>
                        <span><?= number_format($subtotal, 0, '.', ' ') ?> ₽</span>
                    </div>
                    <div class="cart-summary__row">
                        <span>Доставка</span>
                        <span><?= number_format($delivery, 0, '.', ' ') ?> ₽</span>
                    </div>
                </div>
                <div class="cart-summary__total">
                    <span>Итого:</span>
                    <span class="cart-summary__total-value"><?= number_format($total, 0, '.', ' ') ?> ₽</span>
                </div>
                <a href="/checkout" class="btn btn--orange btn--full btn--lg">Перейти к оформлению</a>
            </div>
        </div>
    <?php endif ?>
</div>

<script>
async function changeCartQty(btn, delta) {
    const ctrl = btn.closest('.qty-control');
    const pid  = ctrl.dataset.productId;
    const span = ctrl.querySelector('.qty-control__value');
    const cur  = parseInt(span.textContent);
    const next = cur + delta;
    if (next < 1) { removeFromCart(btn, pid); return; }
    const fd = new FormData();
    fd.append('product_id', pid);
    fd.append('quantity', next);
    try {
        await fetch('/src/actions/product/add_to_cart.php', { method: 'POST', body: fd });
        span.textContent = next;
    } catch(e) { console.error(e); }
}

async function removeFromCart(btn, pid) {
    const item = btn.closest('.cart-item');
    const fd = new FormData();
    fd.append('product_id', pid);
    fd.append('remove', '1');
    try {
        await fetch('/src/actions/product/add_to_cart.php', { method: 'POST', body: fd });
        item.remove();
    } catch(e) { console.error(e); }
}

document.getElementById('check-all')?.addEventListener('change', function() {
    document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
});
</script>
