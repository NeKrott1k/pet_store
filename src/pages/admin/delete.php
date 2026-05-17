<?php

$table = $_GET["table"];
$id = $_GET["id"];

$allowed = ['products', 'categories', 'brands', 'orders', 'users', 'reviews', 'promotions'];

if(!in_array($table, $allowed) || $id<=0){
    header('location: /admin');
    exit;
}

if(in_array($table, ["products", "brands", "users"])){
    $stmt = $connect->prepare("SELECT img FROM $table WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if(!empty($result["img"])){
        $old_file = __DIR__ . "/../../.." . $result['img'];
        if (file_exists($old_file)) {
            unlink($old_file);
        }
    }
}

$stmt = $connect->prepare("DELETE FROM $table WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>