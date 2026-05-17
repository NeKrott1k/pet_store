<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Клиент</th>
                <th>Адрес</th>
                <th>Товаров</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $o): ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= date('d.m.Y H:i', strtotime($o['created_at'])) ?></td>
                <td>
                    <div><?= htmlspecialchars($o['user_name'] ?? '—') ?></div>
                    <div style="font-size:.78rem;color:var(--text-light);"><?= htmlspecialchars($o['user_email'] ?? '') ?></div>
                </td>
                <td><?= htmlspecialchars($o['address'] ?? '—') ?></td>
                <td><?= $o['items_count'] ?></td>
                <td><?= number_format($o['total'] ?? 0, 0, '.', ' ') ?> ₽</td>
                <td><span class="order-status"><?= htmlspecialchars($o['status_name'] ?? 'Новый') ?></span></td>
                <td>
                    <div class="admin-actions">
                        <a href="/admin/orders/update/<?= $o['id'] ?>" class="btn btn--outline btn--sm">Изменить</a>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
