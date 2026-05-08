<?php require_once './header.php'; ?>

<link rel="stylesheet" href="./css/main.css">
<link rel="stylesheet" href="./css/style.css">

<div class="container">

    <div class="breadcrumb">
        <a href="/index.php">Главная</a>
        <span>›</span> Каталог
            <span>›</span>
    </div>

    <div class="catalog-page-head">
        <div>
            <span class="section-label">Каталог</span>
            <h1 class="section-title">Каталог товаров</h1>
        </div>
    </div>

    <div class="catalog-layout">

        <aside class="catalog-sidebar" id="sidebar">

            <div class="filter-title">
                <span>Фильтры</span>
                <button class="filter-toggle" id="filter-toggle" type="button">▼</button>
            </div>

            <form method="GET" id="filter-form">

                <div class="filter-group">
                    <label>Поиск</label>
                    <input type="text" name="q" class="form-control"
                           placeholder="По названию или бренду..."
                           value="" id="search-input">
                </div>

                <div class="filter-group">
                    <label>Категория</label>
                    <select name="category" class="form-control" id="filter-category">
                        <option value="0">Все категории</option>
                            <option value=""> </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Бренд</label>
                    <select name="brand" class="form-control" id="filter-brand">
                        <option value="0">Все бренды</option>
                            <option> </option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Цена, ₽</label>
                    <div class="price-range">
                        <input type="number" name="price_min" class="form-control"
                               placeholder="От" min="0" id="price-min"
                               value="">
                        <span style="color:var(--color-text-light);flex-shrink:0;">—</span>
                        <input type="number" name="price_max" class="form-control"
                               placeholder="До" min="0" id="price-max"
                               value="">
                    </div>
                </div>

                <div class="filter-group">
                    <label>Сортировка</label>
                    <select name="sort" class="form-control" id="filter-sort">
                        <option value="popular">По популярности</option>
                        <option value="new">Новинки</option>
                        <option value="price_asc">Цена: по возрастанию</option>
                        <option value="price_desc">Цена: по убыванию</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;margin-bottom:8px;">Применить фильтры</button>
                <a href="./catalog.php"
                   class="btn btn-outline" style="width:100%;text-align:center;">Сбросить</a>
            </form>
        </aside>

        <div class="catalog-content">
            <div class="catalog-count">
                Найдено товаров: <strong>1</strong>
            </div>

<!--             
                <div class="empty-state">
                    <div class="empty-state__icon">🔍</div>
                    <div class="empty-state__title">Товары не найдены</div>
                    <p>Попробуйте изменить параметры фильтра.</p>
                    <a href="/catalog.php" class="btn btn-primary mt-2">Сбросить фильтры</a>
                </div> -->


                <div class="products-grid">

                    <!-- <?php foreach ($products as $product): render_product_card($product); endforeach; ?>    -->


                    <div class="product-card">
                        <a href="/product.php" class="product-card__img-wrap">
                        <img src="./img/i.webp" alt="">
                        
                        <!-- <div class="product-card__img-placeholder">Где?</div> -->

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
    </div>
</div>

<?php require_once './footer.php'; ?>
