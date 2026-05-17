<?php

$table = "order-statuses";
$tableSQL = str_replace("-", "_", $table);

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
        header("Location: /admin/$table/create");
        exit;
    }
    
    $stmt = $connect->prepare("INSERT INTO $tableSQL (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    header("Location: /admin/$table");
}

$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? [];

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
    <button type="submit">Создать</button>
</form>