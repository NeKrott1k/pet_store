<?php
$table = $_GET["table"] ?? "products";

$result = $connect->query("SELECT * FROM $table");
$rows = $result->fetch_all(MYSQLI_ASSOC);


?>
<table>
    <tr>
        <?php
        foreach (array_keys($rows[0]) as $col):
        ?>
        <th style="text-align: center; border: 1px solid red; "><?= $col ?></th>
        <?php endforeach?>
        <th style="text-align: center; border: 1px solid red; " colspan="2">Действия</th>
    </tr>
    <?php 
    foreach ($rows as $row):
    ?>
        <tr>
            <?php
            foreach ($row as $cell):
            ?>
            <td style="text-align: center; border: 1px solid red;"><?= htmlspecialchars($cell) ?></td>
            <?php endforeach?>
            <td style="text-align: center; border: 1px solid red; "><a href="/admin-edit?table=<?= $table ?>&id=<?= $row['id'] ?>">Ред</a></td>
            <td style="text-align: center; border: 1px solid red; "><a href="/admin-delete?table=<?= $table ?>&id=<?= $row['id'] ?>">Уд</a></td>
        </tr>
    <?php endforeach?>
</table>