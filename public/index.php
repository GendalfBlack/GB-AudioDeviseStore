<?php
// Перевірка статусу сесії та початок сесії, якщо вона не створена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Підключення файлів конфігурації та контролерів
require_once(__DIR__ . '/../app/config.php');
require_once(__DIR__ . '/../app/controllers/ProductController.php');
require_once(__DIR__ . '/../app/controllers/UserController.php');
require_once(__DIR__ . '/../app/controllers/OrderController.php');

// Отримання значення дії з параметра action у запиті GET
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Ініціалізація контролерів
$userController = UserController::getInstance();
$productController = new ProductController();
$orderController = OrderController::getInstance();

// Обробка різних дій залежно від значення action
switch ($action) {
    case 'login':
        handleLogin($userController);
        break;
    case 'register':
        handleRegister($userController);
        break;
    case 'view_product':
        handleViewProduct($productController);
        break;
    case 'decline_order':
        handleDeclineOrder($orderController);
        break;
    default:
        handleDefault($productController);
        break;
}

// Функція обробки логінування
function handleLogin($userController) {
    $userController->login();
}

// Функція обробки реєстрації
function handleRegister($userController) {
    $userController->register();
}

// Функція обробки перегляду продукту
function handleViewProduct($productController) {
    // Отримання ID продукту з параметра id у запиті GET
    $productId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($productId) {
        $productController->viewProductDetails($productId);
        exit;
    } else {
        echo "<p>Error: Product ID not provided</p>";
    }
}

// Функція обробки відмови від замовлення
function handleDeclineOrder($orderController) {
    // Отримання ID замовлення з параметра order_id у запиті GET
    $orderId = isset($_GET['order_id']) ? $_GET['order_id'] : null;
    if ($orderId) {
        $success = $orderController->declineOrder($orderId);
        if ($success) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        } else {
            echo "Failed to decline the order.";
        }
    } else {
        echo "No order ID provided.";
    }
}

// Функція обробки за замовчуванням
function handleDefault($productController) {
    // Отримання всіх продуктів
    $products = $productController->getAllProducts();
    // Підключення файлу переліку продуктів
    include(__DIR__ . '/../app/views/product/list.php');
}
?>
