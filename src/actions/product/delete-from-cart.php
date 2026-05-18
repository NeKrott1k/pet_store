<?php
session_start();

include_once __DIR__ . "/../../config/config.php";
include_once __DIR__ . "/../../config/database.php";

$product_id = $_POST['product_id'];

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'redirect' => '/login']);
    exit;
}

$stmt = $connect->prepare("SELECT id FROM cart_items WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $connect->prepare("SELECT ci.*, p.price, p.discount_percent FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE product_id = ? AND user_id = ?");
$stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
$stmt->execute();
$cart_item = $stmt->get_result()->fetch_assoc();

$quantity = $cart_item['quantity'] ?? 0;

$response = [
    "success" => true,
    "product_price" => $cart_item["price"],
    "count_cart_items" => count($cart_items)
];

if ($cart_item['quantity'] == 1) {
    $quantity = 1;
    $stmt = $connect->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $_SESSION['user_id'], $product_id,);
    $stmt->execute();
    $response["status"] = "deleted";
    $response["product_price"] = $cart_item["price"];
    $response["count_cart_items"] = $response["count_cart_items"] - 1;
} else {
    $quantity = $cart_item['quantity'] - 1;
    $stmt = $connect->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("iii", $quantity, $_SESSION['user_id'], $product_id);
    $stmt->execute();
}



if (!empty($cart_item["discount_percent"])) {
    $response["product_price"] = $cart_item["price"] * (1 - $cart_item["discount_percent"] / 100);
    $response["old_price"] = $cart_item["price"];
}

echo json_encode($response);
exit;
