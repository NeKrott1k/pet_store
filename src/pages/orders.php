<div class="container">
    <div class="page-header">
        <h1 class="page-title">Мои заказы</h1>
    </div>

    <?php if (empty($orders)): ?>
        <div class="catalog-empty">
            <p>Заказов пока нет.</p>
            <a href="/catalog" class="btn btn--primary" style="margin-top:16px;">Перейти в каталог</a>
        </div>
    <?php else: ?>
        <div class="orders-table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>№ заказа</th>
                        <th>Дата</th>
                        <th>Адрес</th>
                        <th>Товаров</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= date('d.m.Y', strtotime($order['created_at'])) ?></td>
                        <td><?= htmlspecialchars($order['address'] ?? '—') ?></td>
                        <td><?= $order['items_count'] ?></td>
                        <td><?= number_format($order['total'] + 500, 0, '.', ' ') ?> ₽</td>
                        <td><span class="order-status"><?= htmlspecialchars($order['status_name'] ?? 'Новый') ?></span></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>
