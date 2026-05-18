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
    $total_amount += $cart_item["product_price"] * $cart_item["quantity"] * (1 - $cart_item["product_discount_percent"] / 100);
}

?>
<div>
    <?php if (!empty($cart_items)): ?>
        <div class="cart_container">
            <input type="checkbox" name="" id="main_checkbox" checked>
            <label for="main_checkbox">Все</label>
            <?php foreach ($cart_items as $cart_item): ?>
                <div id="card_product_<?= $cart_item["product_id"] ?>">
                    <input data-product-id="<?= $cart_item["product_id"] ?>" class="product_checkbox" type="checkbox" onclick="toggleProductCheckbox(this)" name="" data-id="" checked>
                    <img style="height: 50px;" src="<?= $cart_item["product_img"] ?>" alt="">
                    <p><?= $cart_item["product_name"] ?></p>
    
                    <?php if (empty($cart_item["product_discount_percent"])): ?>
                        <p><span id="product_sum_<?= $cart_item["product_id"] ?>"><?= $cart_item["product_price"] * $cart_item["quantity"] ?></span> ₽</p>
                    <?php else: ?>
                        <div><span id="product_sum_<?= $cart_item["product_id"] ?>"><?= $cart_item["product_price"] * $cart_item["quantity"] * (1 - $cart_item["product_discount_percent"] / 100) ?></span> ₽</div>
                        <div>Скидка <span ><?= $cart_item["product_discount_percent"] ?></span> %</div>
                        <div><s id="product_sum_old_<?= $cart_item["product_id"] ?>"><?= $cart_item["product_price"] * $cart_item["quantity"] ?></s> ₽</div>
                    <?php endif ?>
                    <div>
                        <button data-product-id="<?= $cart_item["product_id"] ?>" onclick="increaseCartItem(this)">+</button>
                        <div><span id="in_cart_<?= $cart_item["product_id"] ?>"><?= $cart_item["quantity"] ?></span> шт.</div>
                        <button data-product-id="<?= $cart_item["product_id"] ?>" onclick="decreaseCartItem(this)">-</button>
                    </div>
                    <hr>
                </div>
            <?php endforeach ?>
            <div>
                <p>Итого: <span id="total_amount"><?= $total_amount ?></span> ₽</p>
                <a id="checkout_button" onclick="goToCheckout()" style="cursor: pointer;">Перейти к оформлению</a>
                <div id="checkout_empty_message" style="display: none;">Выберите товары, чтобы перейти к оформлению</div>
            </div>
        </div>
        <div style="display: none;" class="empty_cart">Корзина пуста</div>
    <?php else: ?>
        <div>Корзина пуста</div>
    <?php endif ?>
</div>

<script>
    const main_checkbox = document.getElementById('main_checkbox');
    const product_checkbox = Array.from(document.querySelectorAll('.product_checkbox'));
    const total_amount = document.getElementById('total_amount')
    const checkout_empty_message = document.getElementById('checkout_empty_message')
    const checkout_button = document.getElementById('checkout_button')
    const value = +total_amount.textContent

    window.addEventListener('pageshow', () => {
        main_checkbox.checked = true;
        product_checkbox.forEach(elem => {
            elem.checked = true;
        });
    })


    let selected_id = product_checkbox.map(elem => elem.getAttribute("data-product-id"))


    main_checkbox.addEventListener('change', function() {
        selected_id = main_checkbox.checked ? product_checkbox.map(elem => elem.getAttribute("data-product-id")) : []
        product_checkbox.forEach(elem => {
            elem.checked = main_checkbox.checked;
        });
        if (main_checkbox.checked) {
            checkout_button.style.display = 'block'
            checkout_empty_message.style.display = 'none'
            animateValue(total_amount, total_amount.textContent, value, 400);
        } else {
            checkout_button.style.display = 'none'
            checkout_empty_message.style.display = 'block'
            animateValue(total_amount, total_amount.textContent, 0, 400);
        }
    });

    function toggleProductCheckbox(checkbox) {
        selected_id = Array.from(document.querySelectorAll('.product_checkbox')).filter(elem => elem.checked == true).map(elem => elem.getAttribute("data-product-id"));

        main_checkbox.checked = false
        if (product_checkbox.filter((elem) => elem.checked === false).length == 0) {
            main_checkbox.checked = true
        }

        if (selected_id.length == 0) {
            checkout_button.style.display = 'none'
            checkout_empty_message.style.display = 'block'
        }

        let end_value
        if (checkbox.checked) {
            checkout_button.style.display = 'block'
            checkout_empty_message.style.display = 'none'
            end_value = +total_amount.textContent + +document.querySelector("#product_sum_" + checkbox.getAttribute("data-product-id")).textContent
        } else {
            end_value = total_amount.textContent - document.querySelector("#product_sum_" + checkbox.getAttribute("data-product-id")).textContent
        }

        animateValue(total_amount, total_amount.textContent, end_value, 400);
    }

    function goToCheckout() {
        window.location.href = `/checkout?selected=${selected_id}`;
    }

    async function increaseCartItem(button) {
        let data = await addToCart(button, true)
        if (!data.success) {
            return
        }

        const total_amount = document.getElementById('total_amount')
        const product_sum = document.getElementById('product_sum_' + button.getAttribute("data-product-id"))
        const checkbox = document.querySelector(`[data-product-id="${button.getAttribute('data-product-id')}"]`)
        const product_sum_old = document.getElementById('product_sum_old_' + button.getAttribute("data-product-id"))
        

        if (product_sum_old) {
            animateValue(product_sum_old, product_sum_old.textContent, +product_sum_old.textContent + data.old_price, 400);
        }
        animateValue(product_sum, product_sum.textContent, +product_sum.textContent + data.product_price, 400);
        if (checkbox.checked) {
            animateValue(total_amount, total_amount.textContent, +total_amount.textContent + data.product_price, 400);
        }
    }
    async function decreaseCartItem(button) {
        let data = await deleteFromCart(button, true)
        console.log(data);

        if (!data.success) {
            return
        }

        const card = document.getElementById('card_product_' + button.getAttribute("data-product-id"))
        const total_amount = document.getElementById('total_amount')
        const product_sum = document.getElementById('product_sum_' + button.getAttribute("data-product-id"))
        const checkbox = document.querySelector(`[data-product-id="${button.getAttribute('data-product-id')}"]`)
        const product_sum_old = document.getElementById('product_sum_old_' + button.getAttribute("data-product-id"))

        const empty_cart = document.querySelector('.empty_cart')
        const cart_container = document.querySelector('.cart_container')
        if (data.status == "deleted") {
            card.remove()
        }
        if(data.count_cart_items == 0){
            cart_container.style.display = 'none'
            empty_cart.style.display = 'block'
        }
        if (product_sum_old) {
            animateValue(product_sum_old, product_sum_old.textContent, +product_sum_old.textContent - data.old_price, 400);
        }
        animateValue(product_sum, product_sum.textContent, +product_sum.textContent - data.product_price, 400);
        if (checkbox.checked) {
            animateValue(total_amount, total_amount.textContent, +total_amount.textContent - data.product_price, 400);
        }
    }
</script>