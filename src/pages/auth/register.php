<?php
require __DIR__ . '/../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$fields = [
    "name" => ["type" => "text"],
    "email" => ["type" => "text"],
    "phone" => ["type" => "text"],
    "password" => ["type" => "password"],
    "confirm_password" => ["type" => "password"]
];
$phone_pattern = "/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["verify_code"])) {
    $error = [];
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($name)) {
        $error["name"] = "Заполните поле";
    }

    if (empty($email)) {
        $error["email"] = "Заполните поле";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Неверный формат email";
    } else {
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
    } else if (!preg_match($phone_pattern, $phone)) {
        $error["phone"] = "Неверный формат телефона";
    }

    if (empty($password)) {
        $error["password"] = "Заполните поле";
    }
    if (empty($confirm_password)) {
        $error["confirm_password"] = "Заполните поле";
    }

    if ($password != $confirm_password && !empty($password) && !empty($confirm_password)) {
        $error["confirm_password"] = "Пароли не совпадают";
    }

    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "name" => $name,
            "phone" => $phone,
            "email" => $email
        ];
        header("Location: /register");
        exit();
    }


    //отправка письма
    $code = rand(100000, 999999);
    $_SESSION["email_code"] = $code;
    $_SESSION["pending_registration"] = [
        "name" => $name,
        "phone" => $phone,
        "email" => $email,
        "password" => $password
    ];

    $mail = new PHPMailer(true);

    try {
        // Настройки сервера
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV["MAIL_USERNAME"];
        $mail->Password   = $_ENV["MAIL_PASSWORD"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Отправитель
        $mail->setFrom($_ENV["MAIL_FROM_ADDRESS"], $_ENV["MAIL_FROM_NAME"]);

        // Получатель
        $mail->addAddress($email, $name);

        // Контент письма
        $mail->isHTML(true);
        $mail->Subject = 'Тестовое письмо от PHPMailer';
        $mail->Body    = "
        <h2>Привет! Сосал?</h2>
        <p>Это тестовое письмо, отправленное через <b>PHPMailer</b>.</p>
        <p><b>$code</b></p>
        <p>Всё работает отлично!</p>
        ";
        $mail->AltBody = 'Привет! Это тестовое письмо, отправленное через PHPMailer. Всё работает отлично!'; // Для почтовых клиентов без HTML
        $mail->send();
        $_SESSION["verify_from"] = "register";
        header("Location: /verify-code");
    } catch (Exception $e) {
        $_SESSION["error"]["general"] = "Ошибка отправки кода. Попробуйте позже.";
        $_SESSION["old_input"] = [
            "name" => $name,
            "email" => $email
        ];
        header("Location: /register");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify_code"])) {
    $error = [];
    $user_code = trim($_POST["verify_code"]);

    if (empty($user_code)) {
        $error["verify_code"] = "Введите код";
    } else if ($user_code !== (string)$_SESSION["email_code"]) {
        $error["verify_code"] = "Код не совпадает";
    }

    if (!empty($error)) {
        $_SESSION["error"] = $error;
        header("Location: /verify-code");
        exit();
    }

    $pending = $_SESSION["pending_registration"];
    $hashed_password = password_hash($pending["password"], PASSWORD_DEFAULT);
    $img = null;

    $stmt = $connect->prepare("INSERT INTO users (name, email, phone, password, img) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $pending["name"], $pending["email"], $pending["phone"], $hashed_password, $img);
    $stmt->execute();
    $_SESSION["user_id"] = $connect->insert_id;
    $_SESSION["user_role"] = "user";
    $_SESSION["user_avatar"] = null;
    unset(
        $_SESSION["pending_registration"],
        $_SESSION["email_code"],
        $_SESSION["verify_from"],
    );
    header("Location: /");
    exit;
}



$input_error = $_SESSION["error"] ?? [];
$old_input = $_SESSION["old_input"] ?? [];

unset($_SESSION["error"]);
unset($_SESSION["old_input"]);
?>
<form action="" method="POST">
    <?php foreach ($fields as $field => $config): ?>
        <div>
            <label for=""><?= $field ?>:</label>
            <input id="<?= $field ?>" type="<?= $config["type"] ?>" value="<?= htmlspecialchars($old_input[$field] ?? "") ?>" id="" name="<?= $field ?>">
            <?php
            if (isset($input_error[$field])):
            ?>
                <div style="color: red;"><?= $input_error[$field] ?></div>
            <?php endif ?>
        </div>
    <?php endforeach ?>
    <button type="submit">Регистрация</button>
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