<?php
function product_price_html(array $p): string {
    if ($p['discount_percent'] > 0) {
        $new = number_format($p['price'] * (1 - $p['discount_percent'] / 100), 0, '.', ' ');
        $old = number_format($p['price'], 0, '.', ' ');
        return "<span class='card__price card__price-new'>$new ₽</span><span class='card__price-old'>$old ₽</span>";
    }
    return "<span class='card__price'>" . number_format($p['price'], 0, '.', ' ') . " ₽</span>";
}

function product_badge(array $p): string {
    if ($p['discount_percent'] > 0) return "<span class='badge badge--sale'>Скидка {$p['discount_percent']}%</span>";
    if ($p['is_new'])      return "<span class='badge badge--new'>Новинка</span>";
    if ($p['is_popular'])  return "<span class='badge badge--hit'>Хит</span>";
    return '';
}
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">Каталог товаров</h1>
    </div>

    <form method="GET" action="/catalog" id="catalog-form">
        <div class="catalog-search">
            <div class="catalog-search__icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
            </div>
            <input type="text" name="search" class="form-input" placeholder="Поиск по названию или бренду..." value="<?= htmlspecialchars('') ?>">
        </div>

        <div class="catalog-layout">
            <aside class="filters">
                <div class="filters__title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                    Фильтры
                </div>

                <?php if (!empty($categories)): ?>
                <div class="filters__group">
                    <p class="filters__label">Категория</p>
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="0">Все категории</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] === (int)$cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <?php endif ?>

                <?php if (!empty($brands_list)): ?>
                <div class="filters__group">
                    <p class="filters__label">Бренд</p>
                    <select name="brand" class="form-select" onchange="this.form.submit()">
                        <option value="0">Все бренды</option>
                        <?php foreach ($brands_list as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= $b['id'] === (int)$b['id'] ? 'selected' : '' ?>><?= htmlspecialchars($b['name']) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <?php endif ?>

                <div class="filters__group">
                    <p class="filters__label">Цена, ₽</p>
                    <div class="filters__price-row">
                        <input type="number" name="price_from" class="form-input" placeholder="От" value="<?= '' ?: '' ?>" min="0">
                        <span class="filters__price-sep">—</span>
                        <input type="number" name="price_to" class="form-input" placeholder="До" value="<?= '' ?: '' ?>" min="0">
                    </div>
                </div>

                <div class="filters__group">
                    <p class="filters__label">Сортировка</p>
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="default" <?= '' === 'default' ? 'selected' : '' ?>>По умолчанию</option>
                        <option value="price_asc" <?= '' === 'price_asc' ? 'selected' : '' ?>>Дешевле</option>
                        <option value="price_desc" <?= '' === 'price_desc' ? 'selected' : '' ?>>Дороже</option>
                        <option value="new" <?= '' === 'new' ? 'selected' : '' ?>>Новинки</option>
                    </select>
                </div>

                <a href="/catalog" class="filters__reset">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
                    Сбросить фильтры
                </a>
            </aside>

            <div>
                <p class="catalog-count">Найдено товаров: <?= 1 ?></p>

                <?php if (empty($products)): ?>
                    <div class="catalog-empty">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/></svg>
                        <p>Товары не найдены. Попробуйте изменить фильтры.</p>
                    </div>
                <?php else: ?>
                    <div class="cards-grid">
                        <?php foreach ($products as $p): ?>
                        <div class="card">
                            <a href="/product/<?= $p['id'] ?>">
                                <div class="card__img-wrap">
                                    <img src="<?= htmlspecialchars($p['img'] ?? '') ?>" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.parentElement.style.background='#E8F1EC'">
                                    <div class="card__badges"><?= product_badge($p) ?></div>
                                </div>
                            </a>
                            <div class="card__body">
                                <a href="/product/<?= $p['id'] ?>" class="card__name"><?= htmlspecialchars($p['name']) ?></a>
                                <div class="card__footer">
                                    <div><?= product_price_html($p) ?></div>
                                    <?php $qty = $cart_qtys[$p['id']] ?? 0; ?>
                                    <?php if ($qty > 0): ?>
                                        <div class="qty-control" data-product-id="<?= $p['id'] ?>">
                                            <button class="qty-control__btn" onclick="changeQty(this, -1)">−</button>
                                            <span class="qty-control__value"><?= $qty ?></span>
                                            <button class="qty-control__btn" onclick="changeQty(this, 1)">+</button>
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
        </div>
    </form>
</div>

<script>
async function AddToCart(button) {
    const fd = new FormData();
    fd.append("product_id", button.dataset.productId);
    button.disabled = true;
    try {
        const res = await fetch("/src/actions/product/add_to_cart.php", { method: "POST", body: fd });
        const data = await res.json();
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (data.success) {
            const wrap = button.parentElement;
            const pid = button.dataset.productId;
            wrap.innerHTML = `<div class="qty-control" data-product-id="${pid}">
                <button class="qty-control__btn" onclick="changeQty(this,-1)">−</button>
                <span class="qty-control__value">1</span>
                <button class="qty-control__btn" onclick="changeQty(this,1)">+</button>
            </div>`;
            const badge = document.querySelector('.header__cart-badge');
            if (badge) badge.textContent = parseInt(badge.textContent||'0')+1;
            else {
                const cartIcon = document.querySelector('a[href="/cart"].header__icon');
                if (cartIcon) cartIcon.insertAdjacentHTML('beforeend','<span class="header__cart-badge">1</span>');
            }
        }
    } catch(e) { console.error(e); }
    button.disabled = false;
}

async function changeQty(btn, delta) {
    const ctrl = btn.closest('.qty-control');
    const pid = ctrl.dataset.productId;
    const span = ctrl.querySelector('.qty-control__value');
    const cur = parseInt(span.textContent);
    const next = cur + delta;
    if (next < 1) return;
    const fd = new FormData();
    fd.append("product_id", pid);
    fd.append("quantity", next);
    try {
        await fetch("/src/actions/product/add_to_cart.php", { method: "POST", body: fd });
        span.textContent = next;
    } catch(e) { console.error(e); }
}
</script>
