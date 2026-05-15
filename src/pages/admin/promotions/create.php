<?php

$table = "promotions";
$tableSQL = str_replace("-", "_", $table);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);


    $error = [];

    if (empty($title)) {
        $error["title"] = "Заполните поле";
    }
    if (empty($description)) {
        $error["description"] = "Заполните поле";
    }
    

    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "title" => $title,
            "description" => $description
        ];
        header("Location: /admin/$table/create");
        exit;
    }

    $stmt = $connect->prepare("INSERT INTO $tableSQL (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $description);
    $stmt->execute();
    header("Location: /admin/$table");
}

$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? [];

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<a href="/admin/<?= $table ?>">Назад</a>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= htmlspecialchars($old_input["title"] ?? "") ?>">
    <?php
    if (isset($input_error["title"])):
    ?>
        <div style="color: red;"><?= $input_error["title"] ?></div>
    <?php endif ?>

    <input type="text" name="description" value="<?= htmlspecialchars($old_input["description"] ?? "") ?>">
    <?php
    if (isset($input_error["description"])):
    ?>
        <div style="color: red;"><?= $input_error["description"] ?></div>
    <?php endif ?>
    <button type="submit">Создать</button>
</form>