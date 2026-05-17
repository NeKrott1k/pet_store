<div style="margin-bottom: 16px;">
    <a href="/admin/products/create" class="btn btn--orange btn--full">Добавить</a>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Склад</th>
                <th>Новое</th>
                <th>Популярное</th>
                <th>Рек.</th>
                <th>Скидка</th>
                <th>Категория</th>
                <th>Бренд</th>
                <th>Дата</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td>
                    <?php if (!empty($p['img'])): ?>
                        <img src="<?= htmlspecialchars($p['img']) ?>" class="admin-table__img" alt="">
                    <?php else: ?>
                        <span style="color:var(--text-light);">—</span>
                    <?php endif ?>
                </td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= number_format($p['price'], 0, '.', ' ') ?> ₽</td>
                <td><?= $p['stock'] ?></td>
                <td><?= $p['is_new'] ? '✓' : '—' ?></td>
                <td><?= $p['is_popular'] ? '✓' : '—' ?></td>
                <td><?= $p['is_recommended'] ? '✓' : '—' ?></td>
                <td><?= $p['discount_percent'] > 0 ? $p['discount_percent'] . '%' : '—' ?></td>
                <td><?= htmlspecialchars($p['category_name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($p['brand_name'] ?? '—') ?></td>
                <td><?= date('d.m.Y', strtotime($p['created_at'])) ?></td>
                <td>
                    <div class="admin-actions">
                        <a href="/admin/products/update/<?= $p['id'] ?>" class="btn btn--outline btn--sm">Обновить</a>
                        <a href="/admin/products/delete/<?= $p['id'] ?>" class="btn btn--sm" style="background:#FDECEA;color:#E05252;border-color:#FDECEA;" onclick="return confirm('Удалить товар?')">Удалить</a>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
