<?php
$table = "users";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT id, name, email, phone, role, img, created_at FROM $tableSQL");
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
            <th style="text-align: center; border: 1px solid red;">Имя</th>
            <th style="text-align: center; border: 1px solid red;">Почта</th>
            <th style="text-align: center; border: 1px solid red;">Телефон</th>
            <th style="text-align: center; border: 1px solid red;">Роль</th>
            <th style="text-align: center; border: 1px solid red;">Аватар</th>
            <th style="text-align: center; border: 1px solid red;">Дата создания</th>
            <th style="text-align: center; border: 1px solid red;" colspan="2">Действия</th>
        </tr>
        <?php
        foreach ($rows as $row):
        ?>
            <tr>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["id"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["name"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["email"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["phone"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["role"]) ?></td>
                <?php if (!empty($row["img"])): ?>
                    <td style="text-align: center; border: 1px solid red; height: 50px"><img style="height: 50px" src="<?= $row["img"] ?>" alt=""></td>
                <?php else: ?>
                    <td style="text-align: center; border: 1px solid red; height: 50px"><?= htmlspecialchars(mb_substr($row["name"], 0 ,1)) ?></td>
                <?php endif ?>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["created_at"]) ?></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/update/<?= $row['id'] ?>">Обновить</a></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/delete/<?= $row['id'] ?>">Удалить</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>