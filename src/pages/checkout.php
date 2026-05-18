<?php

$selected_ids = explode(',', $_GET['selected'] ?? '');
$selected_ids = array_filter($selected_ids);

if (empty($selected_ids)) {
    header('Location: /cart');
    exit;
}



$placeholders = implode(', ', array_fill(0, count($selected_ids), '?'));
$stmt = $connect->prepare("SELECT 
ci.id AS cart_item_id, 
p.id as product_id, 
p.img AS product_img, 
p.name AS product_name, 
p.price AS product_price, 
p.stock AS product_stock, 
p.is_new AS product_is_new, 
p.is_popular AS product_is_popular, 
p.is_featured AS product_is_featured, 
p.discount_percent AS product_discount_percent, 
ci.quantity 
FROM cart_items ci 
JOIN products p ON ci.product_id = p.id  WHERE user_id=? AND product_id IN ($placeholders)");
$types = "i" .  str_repeat("i", count($selected_ids));
$stmt->bind_param($types, $_SESSION["user_id"], ...$selected_ids);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$total_amount = 0;
foreach ($cart_items as $cart_item) {
    $total_amount += $cart_item["product_price"] * $cart_item["quantity"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = $_POST['address'];
    if (empty($address)) {
        $_SESSION['error']["address"] = "Введите адрес";
        header("Location: /checkout?selected={$_GET['selected']}");
        exit;
    }

    $stmt = $connect->prepare("INSERT INTO orders (user_id, status_id, address, total_amount) VALUES (?,1,?,?)");
    $stmt->bind_param('isi', $_SESSION["user_id"], $address, $total_amount);
    $stmt->execute();
    $order_id = $connect->insert_id;

    foreach ($cart_items as $cart_item) {
        $stmt = $connect->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?,?,?)");
        $stmt->bind_param('isi', $order_id, $cart_item["product_id"], $cart_item["quantity"]);
        $stmt->execute();

        $stmt = $connect->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->bind_param('i', $cart_item["cart_item_id"]);
        $stmt->execute();
    }
    header("Location: /");
    exit;
}

$input_error = $_SESSION["error"] ?? [];

unset($_SESSION["error"]);
?>
<?php foreach ($cart_items as $cart_item): ?>
    <div id="card_product_<?= $cart_item["product_id"] ?>">
        <img style="height: 50px;" src="<?= $cart_item["product_img"] ?>" alt="">
        <p><?= $cart_item["product_name"] ?></p>
        <p><span id="product_sum_<?= $cart_item["product_id"] ?>"><?= $cart_item["product_price"] * $cart_item["quantity"] ?></span> ₽</p>
        <div id="in_cart_<?= $cart_item["product_id"] ?>"><?= $cart_item["quantity"] ?> шт.</div>
        <hr>
    </div>
<?php endforeach ?>
<form action="" method="POST">
    <input type="text" name="address" placeholder="адрес">
    <?php if (isset($input_error["address"])): ?>
        <div style="color: red;"><?= $input_error["address"] ?></div>
    <?php endif ?>
    <div>
        <p>Итого:<span><?= $total_amount ?></span> ₽</p>
    </div>
    <button>Оформить</button>
</form>