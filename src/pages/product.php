<?php
//получение товаров
$stmt = $connect->prepare("SELECT p.*, ci.quantity FROM products p LEFT JOIN cart_items ci ON ci.product_id = p.id AND ci.user_id = ? WHERE p.id = ?");
$stmt->bind_param("ii", $_SESSION["user_id"], $_GET["id"]);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

$title = $product["name"];
if (!$product) {
    header("Location: /not-found");
    exit;
}

//получение товара из заказа
$stmt = $connect->prepare("SELECT oi.id FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE o.user_id = ? AND oi.product_id = ?");
$stmt->bind_param("ii", $_SESSION["user_id"], $_GET["id"]);
$stmt->execute();
$order_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

//получение отзывов
$stmt = $connect->prepare("SELECT r.id, u.img, u.name AS user_name, r.comment, r.created_at, r.assessment FROM reviews r JOIN users u ON r.user_id = u.id WHERE product_id = ?");
$stmt->bind_param("i", $product["id"]);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


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
        header("Location: /product/{$_GET["id"]}");
        exit;
    }

    $stmt = $connect->prepare("INSERT INTO reviews (user_id, product_id, comment, assessment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $_SESSION["user_id"], $_GET["id"], $comment, $assessment);
    $stmt->execute();
    header("Location: /product/{$_GET["id"]}");
}


$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? [];

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<img style="height: 200px;" src="<?= $product["img"] ?>" alt="img">
<div><?= $product["name"] ?></div>
<div><?= $product["description"] ?></div>
<div><?= $product["price"] ?>руб</div>
<div>на складе: <?= $product["stock"] ?>шт</div>
<div class="control" style="<?= $product["quantity"] == 0 ? "display:none" : '' ?>">
    <button data-product-id="<?= $product["id"] ?>" onclick="addToCart(this)">+</button>
    <div><span id="in_cart_<?= $product["id"] ?>"><?= $product["quantity"] ?></span> шт.</div>
    <button data-product-id="<?= $product["id"] ?>" onclick="removeFromCart(this)">-</button>
</div>
<button style="<?= $product["quantity"] != 0 ? "display:none" : '' ?>" class="add_to_cart_btn" data-product-id="<?= $product["id"] ?>" onclick="addToCartFromProduct(this)">В корзину</button>

<h2>Отзывы</h2>
<?php if (!empty($order_items)): ?>
    <form action="" method="POST">
        <textarea type="text" name="comment"><?= htmlspecialchars($old_input["comment"] ?? "") ?></textarea>
        <?php if (isset($input_error["comment"])): ?>
            <div style="color: red;"><?= $input_error["comment"] ?></div>
        <?php endif ?>


        <select name="assessment" id="">
            <option value="1" <?= ($old_input["assessment"] ?? 0) == 1 ? "selected" : '' ?>>1</option>
            <option value="2" <?= ($old_input["assessment"] ?? 0) == 2 ? "selected" : '' ?>>2</option>
            <option value="3" <?= ($old_input["assessment"] ?? 0) == 3 ? "selected" : '' ?>>3</option>
            <option value="4" <?= ($old_input["assessment"] ?? 0) == 4 ? "selected" : '' ?>>4</option>
            <option value="5" <?= ($old_input["assessment"] ?? 0) == 5 ? "selected" : '' ?>>5</option>
        </select>
        <?php if (isset($input_error["assessment"])): ?>
            <div style="color: red;"><?= $input_error["assessment"] ?></div>
        <?php endif ?>
        <button type="submit">Создать</button>
    </form>
<?php endif ?>
<?php if (empty($reviews)): ?>
    <div>Нет отзывов</div>
<?php else: ?>
    <?php foreach ($reviews as $review): ?>
        <div>
            <div>
                <img style="height: 100px;" src="<?= $review['img'] ?>" alt="">
                <?= htmlspecialchars($review["user_name"]) ?>
                <?php for ($i = 1; $i <= 5; $i++):
                    if ($review["assessment"] >= $i):
                ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="21" viewBox="0 0 22 21" fill="none">
                            <path d="M10.318 0.319384C10.3654 0.223492 10.4388 0.142774 10.5297 0.0863394C10.6206 0.0299048 10.7254 0 10.8324 0C10.9394 0 11.0443 0.0299048 11.1352 0.0863394C11.2261 0.142774 11.2994 0.223492 11.3469 0.319384L13.8487 5.38697C14.0135 5.72051 14.2568 6.00908 14.5577 6.2279C14.8586 6.44673 15.2081 6.58927 15.5762 6.6433L21.1712 7.46209C21.2772 7.47745 21.3768 7.52217 21.4587 7.59119C21.5407 7.66021 21.6016 7.75077 21.6348 7.85264C21.6679 7.95451 21.6719 8.06362 21.6462 8.16763C21.6206 8.27163 21.5663 8.36638 21.4896 8.44116L17.4434 12.3813C17.1765 12.6413 16.9769 12.9623 16.8616 13.3166C16.7463 13.671 16.7189 14.048 16.7816 14.4153L17.7369 19.9821C17.7556 20.0881 17.7441 20.1972 17.7038 20.297C17.6635 20.3967 17.596 20.4832 17.5089 20.5464C17.4219 20.6096 17.3188 20.6471 17.2114 20.6546C17.1041 20.6621 16.9968 20.6392 16.9018 20.5886L11.9003 17.959C11.5708 17.786 11.2041 17.6955 10.8319 17.6955C10.4597 17.6955 10.093 17.786 9.76346 17.959L4.76303 20.5886C4.66808 20.6389 4.56093 20.6615 4.45377 20.6539C4.3466 20.6463 4.24373 20.6087 4.15684 20.5456C4.06996 20.4824 4.00255 20.3961 3.96228 20.2965C3.92202 20.1968 3.91052 20.0879 3.92908 19.9821L4.88325 14.4163C4.94628 14.0489 4.91897 13.6716 4.80369 13.3171C4.6884 12.9626 4.48859 12.6414 4.22151 12.3813L0.175237 8.44225C0.0979006 8.36755 0.0430976 8.27264 0.0170712 8.16832C-0.00895533 8.064 -0.00515896 7.95446 0.0280276 7.85219C0.0612142 7.74992 0.122457 7.65903 0.204779 7.58987C0.287101 7.52071 0.387193 7.47606 0.493653 7.46101L6.0876 6.6433C6.45611 6.58969 6.80608 6.44733 7.10738 6.22848C7.40868 6.00963 7.65228 5.72084 7.81723 5.38697L10.318 0.319384Z" fill="#D96A4A" />
                        </svg>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="21" viewBox="0 0 22 21" fill="none">
                            <path d="M10.318 0.319384C10.3654 0.223492 10.4388 0.142774 10.5297 0.0863394C10.6206 0.0299048 10.7254 0 10.8324 0C10.9394 0 11.0443 0.0299048 11.1352 0.0863394C11.2261 0.142774 11.2994 0.223492 11.3469 0.319384L13.8487 5.38697C14.0135 5.72051 14.2568 6.00908 14.5577 6.2279C14.8586 6.44673 15.2081 6.58927 15.5762 6.6433L21.1712 7.46209C21.2772 7.47745 21.3768 7.52217 21.4587 7.59119C21.5407 7.66021 21.6016 7.75077 21.6348 7.85264C21.6679 7.95451 21.6719 8.06362 21.6462 8.16763C21.6206 8.27163 21.5663 8.36638 21.4896 8.44116L17.4434 12.3813C17.1765 12.6413 16.9769 12.9623 16.8616 13.3166C16.7463 13.671 16.7189 14.048 16.7816 14.4153L17.7369 19.9821C17.7556 20.0881 17.7441 20.1972 17.7038 20.297C17.6635 20.3967 17.596 20.4832 17.5089 20.5464C17.4219 20.6096 17.3188 20.6471 17.2114 20.6546C17.1041 20.6621 16.9968 20.6392 16.9018 20.5886L11.9003 17.959C11.5708 17.786 11.2041 17.6955 10.8319 17.6955C10.4597 17.6955 10.093 17.786 9.76346 17.959L4.76303 20.5886C4.66808 20.6389 4.56093 20.6615 4.45377 20.6539C4.3466 20.6463 4.24373 20.6087 4.15684 20.5456C4.06996 20.4824 4.00255 20.3961 3.96228 20.2965C3.92202 20.1968 3.91052 20.0879 3.92908 19.9821L4.88325 14.4163C4.94628 14.0489 4.91897 13.6716 4.80369 13.3171C4.6884 12.9626 4.48859 12.6414 4.22151 12.3813L0.175237 8.44225C0.0979006 8.36755 0.0430976 8.27264 0.0170712 8.16832C-0.00895533 8.064 -0.00515896 7.95446 0.0280276 7.85219C0.0612142 7.74992 0.122457 7.65903 0.204779 7.58987C0.287101 7.52071 0.387193 7.47606 0.493653 7.46101L6.0876 6.6433C6.45611 6.58969 6.80608 6.44733 7.10738 6.22848C7.40868 6.00963 7.65228 5.72084 7.81723 5.38697L10.318 0.319384Z" fill="#22242880" />
                        </svg>
                    <?php endif ?>
                <?php endfor ?>
            </div>
            <?= htmlspecialchars($review["comment"]) ?>
        </div>
    <?php endforeach ?>
<? endif ?>

<script>

    async function removeFromCart(button) {
        let res = await deleteFromCart(button)
        
        if(res.status == "deleted"){
            const control = document.querySelector(".control")
            const add_to_cart_btn = document.querySelector(".add_to_cart_btn")
            control.style.display = "none"
            add_to_cart_btn.style.display = "block"
        }
    }
    async function addToCartFromProduct(button){
        let res = await addToCart(button)
        
        const control = document.querySelector(".control")
        control.style.display = "block"
        button.style.display = "none"
    }
</script>