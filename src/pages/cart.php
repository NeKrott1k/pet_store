<?php

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
JOIN products p ON ci.product_id = p.id 
WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$total_amount = 0;

foreach ($cart_items as $cart_item) {
    $total_amount += $cart_item["product_price"] * $cart_item["quantity"];
}

?>
<div>
    <input type="checkbox" name="" id="main_checkbox" checked>
    <label for="main_checkbox">Все</label>
    <?php
    foreach ($cart_items as $cart_item): ?>
        <div id="card_product_<?= $cart_item["product_id"] ?>">
            <input id="product_checkbox" type="checkbox" onclick="a(this)" name="" data-id="" checked>
            <img style="height: 50px;" src="<?= $cart_item["product_img"] ?>" alt="">
            <p><?= $cart_item["product_name"] ?></p>
            <p><span id="product_sum_<?= $cart_item["product_id"] ?>"><?= $cart_item["product_price"] * $cart_item["quantity"]?></span> ₽</p>
            <div>
                <button data-product-id="<?= $cart_item["product_id"] ?>" onclick="addToCart(this, true)">+</button>
                <div  id="in_cart_<?= $cart_item["product_id"] ?>"><?= $cart_item["quantity"] ?></div>
                <button data-product-id="<?= $cart_item["product_id"] ?>" onclick="deleteFromCart(this, true)">-</button>
            </div>
            <hr>
        </div>
    <?php endforeach ?>
    <div>
        <p>к оплате: <span id="total_amount"><?= $total_amount ?></span></p>
    </div>
</div>

<script>
    const main_checkbox = document.getElementById('main_checkbox');
    const product_checkbox = Array.from(document.querySelectorAll('#product_checkbox'));

    main_checkbox.addEventListener('change', function() {
        product_checkbox.forEach(elem => {
            elem.checked = main_checkbox.checked;
        });
    });
    function a(checkbox){
        main_checkbox.checked = false
        if(product_checkbox.filter((elem)=> elem.checked === false).length == 0){
            main_checkbox.checked = true
        }
    }
</script>