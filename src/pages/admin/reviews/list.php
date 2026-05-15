<?php
$table = "reviews";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT r.id, u.name AS user_name, p.name AS product_name, r.comment, r.created_at, r.assessment FROM $tableSQL r JOIN users u ON r.user_id = u.id JOIN products p ON r.product_id = p.id");
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
            <th style="text-align: center; border: 1px solid red;">Пользователь</th>
            <th style="text-align: center; border: 1px solid red;">Товар</th>
            <th style="text-align: center; border: 1px solid red;">Коммент</th>
            <th style="text-align: center; border: 1px solid red;">Дата Создания</th>
            <th style="text-align: center; border: 1px solid red;">Рейтинг</th>
            <th style="text-align: center; border: 1px solid red;" colspan="2">Действия</th>
        </tr>
        <?php
        foreach ($rows as $row):
        ?>
            <tr>
                <?php
                foreach ($row as $value):
                ?>
                    <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($value) ?></td>
                <?php endforeach ?>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/update/<?= $row['id'] ?>">Обновить</a></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/delete/<?= $row['id'] ?>">Удалить</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>