<?php

$table = "reviews";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT * FROM $tableSQL WHERE id = ?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = trim($_POST["comment"]);
    $assessment = $_POST["assessment"];


    $error = [];

    if (empty($comment)) {
        $error["comment"] = "Заполните поле";
    }
    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "comment" => $comment,
            "assessment" => $assessment
        ];
        header("Location: /admin/$table/update/{$_GET["id"]}");
        exit;
    }

    $stmt = $connect->prepare("UPDATE $tableSQL SET comment=?, assessment=? WHERE id = ?");
    $stmt->bind_param("sii", $comment, $assessment, $_GET["id"]);
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
    <input type="text" name="comment" value="<?= htmlspecialchars($old_input["comment"] ?? "") ?>">
    <?php if (isset($input_error["comment"])): ?>
        <div style="color: red;"><?= $input_error["comment"] ?></div>
    <?php endif ?>


    <select name="assessment" id="">
        <option value="1" <?= $old_input["assessment"] == 1 ? "selected" : '' ?>>1</option>
        <option value="2" <?= $old_input["assessment"] == 2 ? "selected" : '' ?>>2</option>
        <option value="3" <?= $old_input["assessment"] == 3 ? "selected" : '' ?>>3</option>
        <option value="4" <?= $old_input["assessment"] == 4 ? "selected" : '' ?>>4</option>
        <option value="5" <?= $old_input["assessment"] == 5 ? "selected" : '' ?>>5</option>
    </select>
    <?php if (isset($input_error["assessment"])): ?>
        <div style="color: red;"><?= $input_error["assessment"] ?></div>
    <?php endif ?>
    <button type="submit">Обновить</button>
</form>