<?php
$table = "orders";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT o.id, u.name AS user_name, os.name AS status, o.address, o.total_amount, o.delivery_date, o.created_at FROM $tableSQL o JOIN users u ON o.user_id = u.id JOIN order_statuses os ON o.status_id = os.id");
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


?>
<?php
if (empty($rows)):
?>
<p>Пока ничего нет.</p>
<? else: ?>
    <table style="border-collapse: collapse;">
        <tr>
            <th style="text-align: center; border: 1px solid red;">ID</th>
            <th style="text-align: center; border: 1px solid red;">пользователь</th>
            <th style="text-align: center; border: 1px solid red;">Статус</th>
            <th style="text-align: center; border: 1px solid red;">Адрес</th>
            <th style="text-align: center; border: 1px solid red;">Общая Сумма</th>
            <th style="text-align: center; border: 1px solid red;">Дата доставки</th>
            <th style="text-align: center; border: 1px solid red;">Дата создания</th>
            <th style="text-align: center; border: 1px solid red;" colspan="2">Действия</th>
        </tr>
        <?php
        foreach ($rows as $row):
        ?>
            <tr>
                <?php foreach ($row as $value): ?>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($value) ?></td>
                <?php endforeach ?>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/update/<?= $row['id'] ?>">Обновить</a></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/delete/<?= $row['id'] ?>">Удалить</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>

