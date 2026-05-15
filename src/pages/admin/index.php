<?php

if (!isset($_SESSION["user_id"])) {
    header('Location: /login');
    exit;
}
$stmt = $connect->prepare("SELECT role FROM users WHERE id=?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    session_destroy();
    header('Location: /index.php');
    exit;
}
if (!in_array($user["role"], ['admin', 'manager'])) {
    $_SESSION["user_role"] = "user";
    header('Location: /index.php');
    exit;
}
$_SESSION["user_role"] = $user["role"];


$user_role = $_SESSION["user_role"];

$permissions = [
    "products" => ["admin"],
    "categories" => ["admin"],
    "brands" => ["admin"],
    "order-statuses" => ["admin"],
    "orders" => ["admin", "manager"],
    "promotions" => ["admin"],
    "reviews" => ["admin", "manager"],
    "users" => ["admin"],
];

$managerActions = [
    "orders" => ["list", "update"],
    "reviews" => ["list", "update"],
];

$admin_url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = null;
$section = trim(str_replace("admin", "", $admin_url), "/");

$parts = explode("/", $section, 4);
$page   = $parts[0] ?? '';
$action = $parts[1] ?? 'list';
$id = $parts[2] ?? null;
$trash = $parts[3] ?? null;

if ($page && isset($permissions[$page]) && !in_array($user_role, $permissions[$page])) {
    header('Location: /admin');
    exit;
}
if ($user_role == "manager" && isset($managerActions[$page])) {
    if (!in_array($action, $managerActions[$page])) {
        header('Location: /admin');
        exit;
    }
}


$routes = [
    "" => ["list" => ''],
    "products" => [
        "list" => "/products/list.php",
        "create" => "/products/create.php",
        "update" => "/products/update.php",
        "delete" => "/delete.php"
    ],
    "categories" => [
        "list" => "/categories/list.php",
        "create" => "/categories/create.php",
        "update" => "/categories/update.php",
        "delete" => "/delete.php"
    ],
    "brands" => [
        "list" => "/brands/list.php",
        "create" => "/brands/create.php",
        "update" => "/brands/update.php",
        "delete" => "/delete.php"
    ],
    "order-statuses" => [
        "list" => "/order-statuses/list.php",
        "create" => "/order-statuses/create.php",
        "update" => "/order-statuses/update.php",
        "delete" => "/delete.php"
    ],
    "orders" => [
        "list" => "/orders/list.php",
        // "create" => "/orders/create.php",
        "update" => "/orders/update.php",
        "delete" => "/delete.php"
    ],
    "promotions" => [
        "list" => "/promotions/list.php",
        "create" => "/promotions/create.php",
        "update" => "/promotions/update.php",
        "delete" => "/delete.php"
    ],
    "reviews" => [
        "list" => "/reviews/list.php",
        // "create" => "/reviews/create.php",
        "update" => "/reviews/update.php",
        "delete" => "/delete.php"
    ],
    "users" => [
        "list" => "/users/list.php",
        // "create" => "/users/create.php",
        "update" => "/users/update.php",
        "delete" => "/delete.php"
    ],
];

if ($page && array_key_exists($page, $routes)) {
    $file = $routes[$page][$action];
}
if ($action == "update" || $action == "delete") {
    $_GET["id"] = $id;
    $_GET["table"] = $page;
}

$proverka1 = $id != null && !ctype_digit($id);
$proverka2 = !$file && $section !== "";
$proverka3 = $id == null && in_array($action, ["update", 'delete']);
if ($proverka1 || $proverka2 || $proverka3 || $trash) {
    header('Location: /not-found');
    exit;
}

// if () {
//     header('Location: /not-found');
//     exit;
// }

// if () {
//     header('Location: /not-found');
//     exit;
// }


?>
<?php if (!in_array($action, ["update", 'create'])): ?>
    <h1>Админ-панель</h1>
    <ul>
        <?php
        if($user_role == "admin"):
        ?>
        <li><a href="/admin/products">Товары</a></li>
        <li><a href="/admin/categories">Категории</a></li>
        <li><a href="/admin/brands">Бренды</a></li>
        <li><a href="/admin/order-statuses">Статусы заказов</a></li>
        <li><a href="/admin/promotions">Акции</a></li>
        <li><a href="/admin/users">Пользователи</a></li>
        <?php endif?>
        <li><a href="/admin/orders">Заказы</a></li>
        <li><a href="/admin/reviews">Отзывы</a></li>
    </ul>
<?php endif ?>
<?php

if ($file):
    require_once __DIR__ . $file;
else :
?>
    <h1>Админ-панель Bloop</h1>
    <p>Добро пожаловать! Выберите раздел.</p>
<?php endif ?>