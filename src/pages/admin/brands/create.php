<?php

$table = "brands";
$tableSQL = str_replace("-", "_", $table);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $img = "";


    $error = [];

    if (empty($name)) {
        $error["name"] = "Заполните поле";
    }
    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
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
            $img_name = uniqid("logo_") . "." . $ext;

            $upload_dir = __DIR__ . "/../../../../public/uploads/brands/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            if (move_uploaded_file($file["tmp_name"], $upload_dir . $img_name)) {
                $img = "/public/uploads/brands/" . $img_name;
            } else {
                $error["img"] = "Ошибка загрузки файла";
            }
        }
    }

    if (empty($img)) {
        $error["img"] = "Выберите файл";
    }
    

    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "name" => $name,
            "img" => $img
        ];
        header("Location: /admin/$table/create");
        exit;
    }

    $stmt = $connect->prepare("INSERT INTO $tableSQL (name, img) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $img);
    $stmt->execute();
    header("Location: /admin/$table");
}

$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? [];

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<a href="/admin/<?= $table ?>">Назад</a>
<form action="" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; width:fit-content">
    <input type="text" name="name" value="<?= htmlspecialchars($old_input["name"] ?? "") ?>">
    <?php
    if (isset($input_error["name"])):
    ?>
        <div style="color: red;"><?= $input_error["name"] ?></div>
    <?php endif ?>

    <img id="preview" src="" style="max-width: 200px; margin-top: 10px; display: none;">
    <input id="img" type="file" name="img" value="<?= htmlspecialchars($old_input["img"] ?? "") ?>" accept="image/*" onchange="previewImage(this)">
    <button type="button" onclick="clearFile()" style="display:none;" id="clear-btn">✕</button>
    <?php
    if (isset($input_error["img"])):
    ?>
        <div style="color: red;"><?= $input_error["img"] ?></div>
    <?php endif ?>
    <button type="submit">Создать</button>
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
        console.log(input);
        

        input.value = ''; // сбрасываем поле
        preview.src = ''; // убираем картинку
        preview.style.display = 'none'; // прячем превью
        input.style.display = 'block'; // прячем превью
        clearBtn.style.display = 'none'; // прячем крестик
    }
</script>