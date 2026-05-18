<?php
session_start();

include_once __DIR__ . "/../../config/config.php";
include_once __DIR__ . "/../../config/database.php";

$product_id = $_POST['product_id'];

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'redirect' => '/login']);
    exit;
}

$stmt = $connect->prepare("SELECT stock, discount_percent FROM products  WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();


$stmt = $connect->prepare("SELECT ci.*, p.price, p.stock FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE product_id = ? AND user_id = ?");
$stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
$stmt->execute();
$cart_item = $stmt->get_result()->fetch_assoc();

$quantity = $cart_item['quantity'] ?? 0;

if ($quantity >= $product['stock']) {
    echo json_encode(['success' => false, 'error' => 'stock_limit', "available" => $cart_item['stock']]);
    exit;
}

if (empty($cart_item)) {
    $quantity = 1;
    $stmt = $connect->prepare("INSERT INTO cart_items SET user_id = ?, product_id = ?, quantity  = ?");
    $stmt->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
    $stmt->execute();
    echo json_encode(['success' => true, "status" => "created"]);
    exit;
} else {
    $quantity = $cart_item['quantity'] + 1;
    if ($quantity == $cart_item['stock']) {
        $quantity = $cart_item['stock'];
    }
    $stmt = $connect->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("iii", $quantity, $_SESSION['user_id'], $product_id);
    $stmt->execute();

    
}

if (!empty($product["discount_percent"])) {
    echo json_encode([
        'success' => true,
        "product_price" => $cart_item["price"] * (1 - $product["discount_percent"] / 100),
        "old_price" => $cart_item["price"],
    ]);
    exit;
}
echo json_encode(['success' => true, "product_price" => $cart_item["price"]]);
exit;
