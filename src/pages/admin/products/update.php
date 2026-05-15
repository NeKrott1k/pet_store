<?php

$table = "products";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT * FROM $tableSQL WHERE id = ?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();


$stmt = $connect->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $connect->prepare("SELECT * FROM brands");
$stmt->execute();
$brands = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img               = '';
    $name              = trim($_POST["name"]);
    $description       = trim($_POST["description"]);
    $price             = (int)$_POST["price"];
    $stock             = (int)$_POST["stock"];
    $is_new            = isset($_POST["is_new"]) ? 1 : 0;
    $is_popular        = isset($_POST["is_popular"]) ? 1 : 0;
    $is_featured       = isset($_POST["is_featured"]) ? 1 : 0;
    $discount_percent  = (int)$_POST["discount_percent"] ?? 0;
    $discount_end_date = $_POST["discount_end_date"] ?? null;
    $category_id       = (int)$_POST["category_id"] ?? 0;
    $brand_id          = (int)$_POST["brand_id"] ?? 0;
    $remove_img = $_POST["remove_img"];

    $error = [];

    if (empty($name)) {
        $error["name"] = "Заполните поле";
    }

    if (empty($description)) {
        $error["description"] = "Заполните поле";
    }

    if (empty($price)) {
        $error["price"] = "Заполните поле";
    } else if ($price <= 0) {
        $error["price"] = "Цена больше 0";
    }

    if ($discount_percent < 0 || $discount_percent > 100) {
        $error["discount_percent"] = "Скидка от 0 до 100%";
    }
    if ($discount_percent <= 0 && !empty($discount_end_date)) {
        $discount_end_date = null;
    }

    if (empty($stock)) {
        $error["stock"] = "Заполните поле";
    } else if ($stock < 0) {
        $error["stock"] = "Количество больше 0";
    }

    if ($discount_percent > 0 && empty($discount_end_date)) {
        $error["discount_end_date"] = "Укажите дату окончания скидки";
    }

    if ($_FILES["img"]["error"] == UPLOAD_ERR_NO_FILE && $remove_img == 1) {
        $img = "";
    } else if ($remove_img != 1) {
        $img = $result["img"];
    }

    if (empty($img)) {
        $error["img"] = "Выберите файл";
    }

    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {

        if (!empty($result["logo"]) && empty($error)) {
            $old_file = __DIR__ . "/../../.." . $result['logo'];
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }

        $file = $_FILES["img"];

        $allowed = ["jpg", "jpeg", "png", "webp", "gif"];
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error["img"] = "Неподдерживаемый формат файла";
        }

        if ($file["size"] > 1024 * 1024 * 5) {
            $error["img"] = "Файл больше 5МБ";
        }

        if (!isset($error["img"])) {
            $img_name = uniqid("product_") . "." . $ext;

            $upload_dir = __DIR__ . "/../../../../public/uploads/product/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (!empty($error)) {
                $_SESSION["error"] = $error;
                $_SESSION["old_input"] = $_POST + ["img" => ''];
                header("Location: /admin/$table/update/{$_GET["id"]}");
                exit;
            }

            if (move_uploaded_file($file["tmp_name"], $upload_dir . $img_name)) {
                $img = "/public/uploads/product/" . $img_name;
            } else {
                $error["img"] = "Ошибка загрузки файла";
            }
        }
    }



    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = $_POST + ["img" => $img];

        header("Location: /admin/$table/update/{$_GET["id"]}");
        exit();
    }

    $discount_end_date = $discount_end_date ?: null;

    $stmt = $connect->prepare("UPDATE $tableSQL SET img = ?, name = ?, description = ?, price = ?, stock = ?, is_new = ?, is_popular = ?, is_featured = ?, discount_percent = ?, discount_end_date = ?, category_id = ?, brand_id = ? WHERE id = ?");
    $stmt->bind_param("sssiiiiiisiii", $img, $name, $description, $price, $stock, $is_new, $is_popular, $is_featured, $discount_percent, $discount_end_date, $category_id, $brand_id, $_GET["id"]);
    $stmt->execute();
    header("Location: /admin/$table");
}

$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? $result;

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<a href="/admin/<?= $table ?>">Назад</a>
<form action="" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; width:fit-content">
    <img id="preview" src="<?= htmlspecialchars($old_input["img"] ?? "") ?>" style="max-width: 200px; margin-top: 10px; <?= empty($old_input["img"]) ? "display:none;" : "" ?>">
    <input id="img" type="file" name="img" value="<?= htmlspecialchars($old_input["img"] ?? "") ?>" accept="image/*" onchange="previewImage(this)" style=" <?= empty($old_input["img"]) ? "" : "display:none;" ?>">
    <input type="hidden" id="remove_img" name="remove_img" value="<?= empty($old_input["img"]) ? "1" : "0" ?>">
    <button type="button" style=" <?= empty($old_input["img"]) ? "display:none;" : "" ?>" onclick="clearFile()" id="clear-btn">✕</button>
    <?php
    if (isset($input_error["img"])):
    ?>
        <div style="color: red;"><?= $input_error["img"] ?></div>
    <?php endif ?>


    <input type="text" name="name" value="<?= htmlspecialchars($old_input["name"] ?? "") ?>" placeholder="Название">
    <?php if (isset($input_error["name"])): ?>
        <div style="color: red;"><?= $input_error["name"] ?></div>
    <?php endif ?>


    <input type="text" name="description" value="<?= htmlspecialchars($old_input["description"] ?? "") ?>" placeholder="Описание">
    <?php if (isset($input_error["description"])): ?>
        <div style="color: red;"><?= $input_error["description"] ?></div>
    <?php endif ?>


    <input type="number" name="price" value="<?= htmlspecialchars($old_input["price"] ?? "") ?>" placeholder="Цена">
    <?php if (isset($input_error["price"])): ?>
        <div style="color: red;"><?= $input_error["price"] ?></div>
    <?php endif ?>


    <input type="number" name="stock" value="<?= htmlspecialchars($old_input["stock"] ?? "") ?>" placeholder="На складе">
    <?php if (isset($input_error["stock"])): ?>
        <div style="color: red;"><?= $input_error["stock"] ?></div>
    <?php endif ?>


    <input type="text" name="discount_percent" value="<?= htmlspecialchars($old_input["discount_percent"] ?? "") ?>" placeholder="Скидка">
    <?php if (isset($input_error["discount_percent"])): ?>
        <div style="color: red;"><?= $input_error["discount_percent"] ?></div>
    <?php endif ?>


    <input type="date" name="discount_end_date" value="<?= htmlspecialchars($old_input["discount_end_date"] ?? "") ?>" placeholder="Окончание скидки">
    <?php if (isset($input_error["discount_end_date"])): ?>
        <div style="color: red;"><?= $input_error["discount_end_date"] ?></div>
    <?php endif ?>

    <div>
        <input id="is_new" type="checkbox" name="is_new" <?= $old_input["is_new"] == 1 ? "checked" : "" ?> value="<?= htmlspecialchars($old_input["is_new"] ?? "") ?>" placeholder="Окончание скидки">
        <label for="is_new">Новое</label>
    </div>
    <div>
        <input id="is_popular" type="checkbox" name="is_popular" <?= $old_input["is_popular"] == 1 ? "checked" : "" ?> value="<?= htmlspecialchars($old_input["is_popular"] ?? "") ?>" placeholder="Окончание скидки">
        <label for="is_popular">Популярное</label>
    </div>
    <div>
        <input id="is_featured" type="checkbox" name="is_featured" <?= $old_input["is_featured"] == 1 ? "checked" : "" ?> value="<?= htmlspecialchars($old_input["is_featured"] ?? "") ?>" placeholder="Окончание скидки">
        <label for="is_featured">Рекомендуемое</label>
    </div>

    <select name="category_id" id="">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>" <?= $category['id'] == $result["category_id"] ? "selected" : "" ?>><?= $category['name'] ?></option>
        <?php endforeach ?>
    </select>

    <select name="brand_id" id="">
        <?php foreach ($brands as $brand): ?>
            <option value="<?= $brand['id'] ?>" <?= $brand['id'] == $result["brand_id"] ? "selected" : "" ?>><?= $brand['name'] ?></option>
        <?php endforeach ?>
    </select>


    <button>Обновить</button>
</form>
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const clearBtn = document.getElementById('clear-btn');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                input.style.display = 'none';
                clearBtn.style.display = 'block';
                remove_img.value = 0;
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }

    function clearFile() {
        const input = document.getElementById('img');
        const preview = document.getElementById('preview');
        const clearBtn = document.getElementById('clear-btn');

        input.value = ''; // сбрасываем поле
        preview.src = ''; // убираем картинку
        preview.style.display = 'none'; // прячем превью
        input.style.display = 'block'; // прячем превью
        clearBtn.style.display = 'none'; // прячем крестик
        remove_img.value = 1;
    }
</script>