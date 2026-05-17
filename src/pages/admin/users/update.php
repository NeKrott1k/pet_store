<?php

$table = "users";
$tableSQL = str_replace("-", "_", $table);

$stmt = $connect->prepare("SELECT * FROM $tableSQL WHERE id = ?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $role = trim($_POST["role"]);
    $img = $result["img"];
    $password = trim($_POST["password"]);
    $remove_img = $_POST["remove_img"];


    $error = [];
    //проверка полей
    if (empty($name)) {
        $error["name"] = "Заполните поле";
    }

    if (empty($email)) {
        $error["email"] = "Заполните поле";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Неверный формат email";
    } else if ($email != $result["email"]) {
        $stmt = $connect->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error["email"] = "Этот email уже зарегистрирован";
        }
    }
    if (empty($phone)) {
        $error["phone"] = "Заполните поле";
    } else if (!preg_match("/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/", $phone)) {
        $error["phone"] = "Неверный формат телефона";
    }

    //проверка аватарки
    if ($_FILES["img"]["error"] == UPLOAD_ERR_NO_FILE && $remove_img == 1) {
        if (!empty($result["img"]) && empty($error)) {
            $old_file = __DIR__ . "/../../../.." . $result['img'];
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }
        $img = null;
    }


    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {

        if (!empty($result["img"]) && empty($error)) {
            $old_file = __DIR__ . "/../../../.." . $result['img'];
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

        if (!empty($error)) {
            $_SESSION["error"] = $error;
            $_SESSION["old_input"] = [
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "role" => $role,
                "img" => '',
                "password" => $password,
            ];
            header("Location: /admin/$table/update/{$_GET["id"]}");
            exit;
        }

        if (!isset($error["img"])) {
            $img_name = uniqid("img_") . "." . $ext;

            $upload_dir = __DIR__ . "/../../../../public/uploads/avatar/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($file["tmp_name"], $upload_dir . $img_name)) {
                $img = "/public/uploads/avatar/" . $img_name;
            } else {
                $error["img"] = "Ошибка загрузки файла";
            }
        }
    }

    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "role" => $role,
            "img" => $img,
            "password" => $password,
        ];
        header("Location: /admin/$table/update/{$_GET["id"]}");
        exit;
    }
    if (empty($password)) {
        $stmt = $connect->prepare("UPDATE $tableSQL SET name=?, email=?, phone=?, role=?, img=? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $role, $img,  $_GET["id"]);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connect->prepare("UPDATE $tableSQL SET name=?, email=?, phone=?, role=?, password=?, img=? WHERE id = ?");
        $stmt->bind_param("ssssssi", $name, $email, $phone, $role, $hashed_password, $img,  $_GET["id"]);
    }

    $stmt->execute();
    header("Location: /admin/$table");
}

$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? $result;

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<a href="/admin/<?= $table ?>">Назад</a>
<form action="" method="POST" enctype="multipart/form-data">
    <img id="preview" src="<?= htmlspecialchars($old_input["img"] ?? "") ?>" style="max-width: 200px; margin-top: 10px; <?= empty($old_input["img"]) ? "display:none;" : "" ?>"> <!--превью -->
    <input id="img" type="file" name="img" style="<?= empty($old_input["img"]) ? "" : "display:none;" ?>" value="<?= htmlspecialchars($old_input["img"] ?? "") ?>" accept="image/*" onchange="previewImage(this)">
    <input type="hidden" id="remove_img" name="remove_img" value="0">
    <button type="button" onclick="clearFile()" style="<?= empty($old_input["img"]) ? "display:none;" : "" ?>" id="clear-btn">✕</button>
    <?php if (isset($input_error["img"])): ?>
        <div style="color: red;"><?= $input_error["img"] ?></div>
    <?php endif ?>


    <input type="text" name="name" value="<?= htmlspecialchars($old_input["name"] ?? "") ?>">
    <?php if (isset($input_error["name"])): ?>
        <div style="color: red;"><?= $input_error["name"] ?></div>
    <?php endif ?>

    <input type="text" name="email" value="<?= htmlspecialchars($old_input["email"] ?? "") ?>">
    <?php if (isset($input_error["email"])): ?>
        <div style="color: red;"><?= $input_error["email"] ?></div>
    <?php endif ?>

    <input id="phone" type="text" name="phone" value="<?= htmlspecialchars($old_input["phone"] ?? "") ?>">
    <?php if (isset($input_error["phone"])): ?>
        <div style="color: red;"><?= $input_error["phone"] ?></div>
    <?php endif ?>

    <select name="role" id="">
        <option value="user" <?= $old_input["role"] == "user" ? "selected" : '' ?>>Пользователь</option>
        <option value="manager" <?= $old_input["role"] == "manager" ? "selected" : '' ?>>Менеджер</option>
        <option value="admin" <?= $old_input["role"] == "admin" ? "selected" : '' ?>>Админ</option>
    </select>
    <?php if (isset($input_error["rating"])): ?>
        <div style="color: red;"><?= $input_error["rating"] ?></div>
    <?php endif ?>

    <input type="password" name="password" placeholder="Новый пароль" autocomplete="new-password">
    <button type="submit">Обновить</button>
</form>
<script src="https://unpkg.com/imask"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            IMask(phoneInput, {
                mask: '+{7} (000) 000-00-00'
            });
        }
    });
</script>
<script>
    function previewImage(input) {
        const remove_img = document.getElementById('remove_img');
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
        const remove_img = document.getElementById('remove_img');
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