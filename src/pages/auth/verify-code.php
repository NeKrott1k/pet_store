<?php
$from = $_SESSION["verify_from"] ?? '';
// unset($_SESSION["verify_from"]);
print_r($_SESSION);

if(!in_array($from, ["register", "login"])){
    header("Location: /");
    exit;
}


$input_error = $_SESSION["error"] ?? [];

unset($_SESSION["error"]);
?>
<form action="/<?= $from ?>" method="POST">
    <label for="">Введите код.</label>
    <label for="">код отправлен на почту</label>
    <input type="text" name="verify_code">
    <?php if (isset($input_error["verify_code"])): ?>
        <div style="color: red;"><?= $input_error["verify_code"] ?></div>
    <?php endif ?>
    <button type="submit">Submit</button>
</form>