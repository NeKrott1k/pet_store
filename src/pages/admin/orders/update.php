<?php

$table = "orders";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT * FROM $tableSQL WHERE id = ?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$stmt = $connect->prepare("SELECT * FROM order_statuses");
$stmt->execute();
$order_statuses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status_id = trim($_POST["status_id"]);

    $error = [];


    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "status_id" => $status_id
        ];
        header("Location: /admin/$table/update/{$_GET["id"]}");
        exit;
    }

    $stmt = $connect->prepare("UPDATE $tableSQL SET status_id=? WHERE id = ?");
    $stmt->bind_param("ii", $status_id,$_GET["id"]);
    $stmt->execute();
    header("Location: /admin/$table");
}

$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? $result;

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<a href="/admin/<?= $table ?>">Назад</a>
<form action="" method="POST" enctype="multipart/form-data">
    <select name="status_id" id="">
        <?php foreach ($order_statuses as $order_status): ?>
            <option value="<?= htmlspecialchars($order_status["id"]) ?>" <?= $result["status_id"] == $order_status["id"] ? "selected" : "" ?>><?= htmlspecialchars($order_status["name"]) ?></option>
        <?php endforeach ?>
    </select>
    <button type="submit">Обновить</button>
</form>