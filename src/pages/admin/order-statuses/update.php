<?php

$table = "order-statuses";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT * FROM $tableSQL WHERE id = ?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);


    $error = [];

    if (empty($name)) {
        $error["name"] = "Заполните поле";
    }
    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "name" => $name
        ];
        header("Location: /admin/$table/update/{$_GET["id"]}");
        exit;
    }
    
    $stmt = $connect->prepare("UPDATE $tableSQL SET name=? WHERE id = ?");
    $stmt->bind_param("si", $name, $_GET["id"]);
    $stmt->execute();
    header("Location: /admin/$table");
}

$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? $result;

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<a href="/admin/<?= $table ?>">Назад</a>
<form action="" method="POST">
    <input type="text" name="name" value="<?= htmlspecialchars($old_input["name"] ?? "") ?>">
    <?php
    if (isset($input_error["name"])):
    ?>
        <div style="color: red;"><?= $input_error["name"] ?></div>
    <?php endif ?>
    <button type="submit">Обновить</button>
</form>