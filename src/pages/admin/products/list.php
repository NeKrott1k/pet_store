<?php
$table = "products";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT p.id, p.img, p.name, p.price, p.description, p.stock, p.is_new, p.is_popular, p.is_featured, p.discount_percent, p.discount_end_date, c.name AS category_name, b.name AS brand_name FROM $tableSQL p JOIN categories c ON p.category_id = c.id JOIN brands b ON p.brand_id = b.id");
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
            <th style="text-align: center; border: 1px solid red;">Картинка</th>
            <th style="text-align: center; border: 1px solid red;">Название</th>
            <th style="text-align: center; border: 1px solid red;">Цена</th>
            <th style="text-align: center; border: 1px solid red;">Описание</th>
            <th style="text-align: center; border: 1px solid red;">На складе</th>
            <th style="text-align: center; border: 1px solid red;">Новое</th>
            <th style="text-align: center; border: 1px solid red;">Популярное</th>
            <th style="text-align: center; border: 1px solid red;">Рекомендуемое</th>
            <th style="text-align: center; border: 1px solid red;">Процент скидки</th>
            <th style="text-align: center; border: 1px solid red;">Конец скидки</th>
            <th style="text-align: center; border: 1px solid red;">Категория</th>
            <th style="text-align: center; border: 1px solid red;">Бренд</th>
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
                <td style="text-align: center; border: 1px solid red; height: 50px;"><img style="height: 50px;" src="<?= htmlspecialchars($row["img"]) ?>" alt="img"></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["name"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["price"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["description"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["stock"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["is_new"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["is_popular"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["is_featured"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["discount_percent"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["discount_end_date"] ?? "null") ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["category_name"]) ?></td>
                <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($row["brand_name"]) ?></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/update/<?= $row['id'] ?>">Обновить</a></td>
                <td style="text-align: center; border: 1px solid red; "><a href="<?= $table ?>/delete/<?= $row['id'] ?>">Удалить</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>