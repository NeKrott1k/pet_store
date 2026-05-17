<div class="container">
    <div class="page-header">
        <h1 class="page-title">Бренды</h1>
    </div>

    <?php if (empty($brands_list)): ?>
        <div class="brands-empty">Бренды появятся совсем скоро.</div>
    <?php else: ?>
        <div class="brands-list">
            <?php foreach ($brands_list as $brand): ?>
            <a href="/catalog?brand=<?= $brand['id'] ?>" class="brand-item">
                <div class="brand-item__logo">
                    <?php if (!empty($brand['img'])): ?>
                        <img src="<?= htmlspecialchars($brand['img']) ?>" alt="<?= htmlspecialchars($brand['name']) ?>">
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ccc" style="width:28px;height:28px;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    <?php endif ?>
                </div>
                <span class="brand-item__name"><?= htmlspecialchars($brand['name']) ?></span>
            </a>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
