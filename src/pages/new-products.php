<div class="container">
    <div class="page-header">
        <div class="new-products-header">
            <h1 class="page-title">Новинки</h1>
            <span class="new-products-count"><?= count($products) ?> <?= count($products) === 1 ? 'товар' : (count($products) < 5 ? 'товара' : 'товаров') ?></span>
        </div>
    </div>

    <?php if (empty($products)): ?>
        <div class="catalog-empty">
            <p>Новинок пока нет. Загляните позже!</p>
        </div>
    <?php else: ?>
        <div class="cards-grid">
            <?php foreach ($products as $p):
                $disc  = $p['discount_percent'] > 0;
                $price = $disc ? $p['price'] * (1 - $p['discount_percent'] / 100) : $p['price'];
                $qty   = $cart_qtys[$p['id']] ?? 0;
            ?>
            <div class="card">
                <a href="/product/<?= $p['id'] ?>">
                    <div class="card__img-wrap">
                        <img src="<?= htmlspecialchars($p['img'] ?? '') ?>" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.parentElement.style.background='#E8F1EC'">
                        <div class="card__badges"><span class="badge badge--new">Новинка</span></div>
                    </div>
                </a>
                <div class="card__body">
                    <a href="/product/<?= $p['id'] ?>" class="card__name"><?= htmlspecialchars($p['name']) ?></a>
                    <div class="card__footer">
                        <div>
                            <span class="card__price <?= $disc ? 'card__price-new' : '' ?>"><?= number_format($price, 0, '.', ' ') ?> ₽</span>
                            <?php if ($disc): ?><span class="card__price-old"><?= number_format($p['price'], 0, '.', ' ') ?> ₽</span><?php endif ?>
                        </div>
                        <?php if ($qty > 0): ?>
                            <div class="qty-control" data-product-id="<?= $p['id'] ?>">
                                <button class="qty-control__btn" onclick="changeQty(this,-1)">−</button>
                                <span class="qty-control__value"><?= $qty ?></span>
                                <button class="qty-control__btn" onclick="changeQty(this,1)">+</button>
                            </div>
                        <?php else: ?>
                            <button class="btn btn--orange btn--sm" onclick="AddToCart(this)" data-product-id="<?= $p['id'] ?>">В корзину</button>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<script>
async function AddToCart(btn) {
    const fd = new FormData(); fd.append("product_id", btn.dataset.productId); btn.disabled = true;
    try {
        const res = await fetch("/src/actions/product/add_to_cart.php", {method:"POST",body:fd});
        const data = await res.json();
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (data.success) {
            const wrap = btn.parentElement; const pid = btn.dataset.productId;
            wrap.innerHTML = `<div class="qty-control" data-product-id="${pid}"><button class="qty-control__btn" onclick="changeQty(this,-1)">−</button><span class="qty-control__value">1</span><button class="qty-control__btn" onclick="changeQty(this,1)">+</button></div>`;
        }
    } catch(e){} btn.disabled = false;
}
async function changeQty(btn, delta) {
    const ctrl = btn.closest('.qty-control'); const span = ctrl.querySelector('.qty-control__value');
    const next = parseInt(span.textContent) + delta; if (next < 1) return;
    const fd = new FormData(); fd.append("product_id", ctrl.dataset.productId); fd.append("quantity", next);
    try { await fetch("/src/actions/product/add_to_cart.php",{method:"POST",body:fd}); span.textContent = next; } catch(e){}
}
</script>
