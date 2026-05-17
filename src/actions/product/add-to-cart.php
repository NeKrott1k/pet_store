<?php
session_start();

include_once __DIR__ . "/../../config/config.php";
include_once __DIR__ . "/../../config/database.php";

$product_id = $_POST['product_id'];

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'redirect' => '/login']);
    exit;
}

$stmt = $connect->prepare("SELECT ci.*, p.price FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$cart_item = $stmt->get_result()->fetch_assoc();

$quantity = $cart_item['quantity'] ?? 0;

if (empty($cart_item)) {
    $quantity = 1;
    $stmt = $connect->prepare("INSERT INTO cart_items SET user_id = ?, product_id = ?, quantity  = ?");
    $stmt->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
    $stmt->execute();
} else {
    $quantity = $cart_item['quantity'] + 1;
    $stmt = $connect->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("iii",$quantity, $_SESSION['user_id'], $product_id);
    $stmt->execute();
}
echo json_encode(['success' => true, "product_price" => $cart_item["price"]]);
exit;
