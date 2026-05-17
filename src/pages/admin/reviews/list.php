<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Товар</th>
                <th>Оценка</th>
                <th>Отзыв</th>
                <th>Дата</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['user_name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($r['product_name'] ?? '—') ?></td>
                <td><?= $r['assessment'] ?>/5</td>
                <td style="max-width:300px;"><?= htmlspecialchars($r['comment']) ?></td>
                <td><?= date('d.m.Y', strtotime($r['created_at'])) ?></td>
                <td>
                    <a href="/admin/reviews/delete/<?= $r['id'] ?>" class="btn btn--sm" style="background:#FDECEA;color:#E05252;border-color:#FDECEA;" onclick="return confirm('Удалить отзыв?')">Удалить</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
