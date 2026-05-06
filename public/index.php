<?php

session_start();

//получение url ()
$url = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

$file = null;
$title = "Bloop";
$show_footer = false;

//динамический пути
$entity_map = [
    'product' => ['pattern' => '/^product\/(\d+)$/', 'file' => 'src/pages/product.php', 'show_footer' => true],
];


//статические пути
$routes = [
    ''       => ['file' => 'src/pages/catalog.php', 'title' => 'Главная', 'show_footer' => true, 'roles' => []],
    'cart'   => ['file' => 'src/pages/cart.php', 'title' => 'Корзина', 'show_footer' => true, 'roles' => ['user', 'admin', 'manager']],
    'admin'  => ['file' => 'src/pages/admin.php', 'title' => 'Админка', 'roles' => ['admin']],
    'orders' => ['file' => 'src/pages/orders.php', 'title' => 'Заказы', 'roles' => ['admin', 'manager']],
    'login'  => ['file' => 'src/pages/login.php', 'title' => 'Вход', 'roles' => []],
    'not-found'  => ['file' => 'src/pages/not-found.php', 'title' => 'Вход', 'roles' => []],
];

//проверяем url на динамический маршрут через регулярное выражение
foreach ($entity_map as $route) {
    if (preg_match($route['pattern'], $url, $matches)) {
        $id = $matches[1];
        $_GET['id'] = $id;
        $file = $route['file'];
        $title = $route["title"] ?? "Bloop";
        $show_footer = $route["show_footer"] ?? false;
        break;
    }
}

//если не динамический маршрут, то проверяем на статический
if (!$file && array_key_exists($url, $routes)) {
    $file = $routes[$url]['file'];
    $title = $routes[$url]["title"] ?? "Bloop";
    $show_footer = $routes[$url]["show_footer"] ?? false;
}

//если не статический маршрут, то перекидываем на страницу not-found
if (!$file) {
    header("Location: /not-found");
    exit;
}

if ($url == "not-found") {
    http_response_code(404);
}

ob_start();

require_once __DIR__ . "/../" . $file;
$page_content = ob_get_clean();

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/public/assets/css/main.css">
</head>

<body>
    <?php if($url != "not-found"):?>
        <?php require_once __DIR__ . "/../" . "src/components/header.php" ?>
    <?php endif ?>
    <div id="root">
        <?= $page_content ?>
    </div>
    <?php if ($show_footer == true): ?>
        <?php require_once __DIR__ . "/../" . "src/components/footer.php" ?>
    <?php endif ?>
</body>

</html>