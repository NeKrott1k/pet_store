<?php
require __DIR__ . '/../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



$fields = [
    "email" => ["type" => "text"],
    "password" => ["type" => "password"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["verify_code"])) {
    $error = [];
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email)) {
        $error["email"] = "Заполните поле";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "Неверный формат email";
    }

    if (empty($password)) {
        $error["password"] = "Заполните поле";
    }

    if (!empty($error)) {
        $_SESSION["error"] = $error;
        $_SESSION["old_input"] = [
            "email" => $email
        ];
        header("Location: /login");
        exit();
    }

    $stmt = $connect->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_array(MYSQLI_ASSOC);

    if (!$user || !password_verify($password, $user["password"])) {
        $_SESSION["error"]["general"] = "неверный логин или пароль";
        $_SESSION["old_input"] = [
            "email" => $email
        ];
        header("Location: /login");
        exit();
    }


    //отправка письма
    $_SESSION["pending_user"]=[
        "id" => $user["id"],
        "avatar" => $user["avatar"],
        "role" => $user["role"]
    ];
    $code = rand(100000, 999999);
    $_SESSION["email_code"] = $code;

    $mail = new PHPMailer(true);

    try {
        // Настройки сервера
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'timgizzat@gmail.com';
        $mail->Password   = 'nvdz ouhi sfqj jwvu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Отправитель
        $mail->setFrom('timgizzat@gmail.com', 'Тимур');

        // Получатель
        $mail->addAddress($email, $user["name"]);

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
        $_SESSION["verify_from"] = "login";
        header("Location: /verify-code");
    } catch (Exception $e) {
        $_SESSION["error"]["general"] = "Ошибка отправки кода. Попробуйте позже.";
        $_SESSION["old_input"] = [
            "password" => $password,
            "email" => $email
        ];
        header("Location: /register");
        exit();
    }


    
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify_code"])) {
    $error = [];
    echo($_POST["verify_code"]);
    $user_code = trim($_POST["verify_code"]);

    if (empty($user_code)) {
        $error["verify_code"] = "Введите код";
    }else if ($user_code !== (string)$_SESSION["email_code"]) {
        $error["verify_code"] = "Код не совпадает";
    }

    if (!empty($error)) {
        $_SESSION["error"] = $error;
        header("Location: /verify-code");
        exit();
    }

    $_SESSION["user_id"] = $_SESSION["pending_user"]["id"];
    $_SESSION["user_role"] = $_SESSION["pending_user"]["role"];
    $_SESSION["user_avatar"] = $_SESSION["pending_user"]["avatar"];
    unset(
        $_SESSION["pending_user"],
        $_SESSION["email_code"]
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
    <?php
    if (isset($input_error["general"])):
    ?>
        <div style="color: red;"><?= $input_error["general"] ?></div>
    <?php endif ?>
    <?php foreach ($fields as $field => $config): ?>
        <div>
            <label for=""><?= $field ?>:</label>
            <input type="<?= $config["type"] ?>" value="<?= htmlspecialchars($old_input[$field] ?? "") ?>" id="" name="<?= $field ?>">
            <?php
            if (isset($input_error[$field])):
            ?>
                <div style="color: red;"><?= $input_error[$field] ?></div>
            <?php endif ?>
        </div>
    <?php endforeach ?>

    <button type="submit">Войти</button>
</form>