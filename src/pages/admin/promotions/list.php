<?php
$table = "promotions";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT id, title, description FROM $tableSQL");
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


?>
<a style="background-color: gray; padding: 10px; height: fit-content; display:block; width: fit-content;" href="<?= $table ?>/create">Добавить</a>
<?php
if (empty($rows)):
?>
<p>Пока ничего нет.</p>
<? else: ?>
    <table style="border-collapse: collapse;">
        <tr>
            <th style="text-align: center; border: 1px solid red;">ID</th>
            <th style="text-align: center; border: 1px solid red;">Название</th>
            <th style="text-align: center; border: 1px solid red;">Описание</th>
            <th style="text-align: center; border: 1px solid red;" colspan="2">Действия</th>
        </tr>
        <?php
        foreach ($rows as $row):
        ?>
            <tr>
                <?php
                foreach ($row as $value):
                ?>
                <?php endforeach ?>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["id"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["title"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["description"]) ?></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/update/<?= $row['id'] ?>">Обновить</a></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/delete/<?= $row['id'] ?>">Удалить</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>

