<?php

$stmt = $connect->prepare("SELECT 
o.id, 
u.name AS user_name, 
os.name AS status,
o.address, o.total_amount, 
o.delivery_date, 
o.created_at 
FROM orders o 
JOIN users u ON o.user_id = u.id 
JOIN order_statuses os ON o.status_id = os.id
WHERE user_id = ?");
$stmt->bind_param('i', $_SESSION["user_id"]);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


?>
<?php
if (empty($orders)):
?>
    <p>Пока ничего нет.</p>
<? else: ?>
    <?php foreach ($orders as $order):
        $stmt = $connect->prepare("
            SELECT oi.product_id, oi.quantity, p.price, p.name, p.img
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->bind_param('i', $order['id']);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    ?>
        <div style="margin-bottom: 20px;">
            <div>Заказ №<?= $order['id'] ?></div>
            <div>статус <?= $order['status'] ?></div>
            <div>
                Товары
                <?php foreach ($products as $product):
                ?>
                    <div>
                        <img style="height: 50px;" src="<?= $product["img"] ?>" alt="">
                        <p><?= $product["name"] ?></p>
                        <p><span><?= $product["price"] * $product["quantity"] ?></span> ₽</p>
                        <div>
                            <div><span><?= $product["quantity"] ?></span> шт.</div>
                        </div>
                        <hr>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>