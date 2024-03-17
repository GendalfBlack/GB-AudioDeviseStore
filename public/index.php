<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../app/config.php');
require_once(__DIR__ . '/../app/controllers/ProductController.php');
require_once(__DIR__ . '/../app/controllers/UserController.php');
require_once(__DIR__ . '/../app/controllers/OrderController.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

$userController = UserController::getInstance();
$productController = new ProductController();
$orderController = OrderController::getInstance();

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

function handleLogin($userController) {
    $userController->login();
}

function handleRegister($userController) {
    $userController->register();
}

function handleViewProduct($productController) {
    $productId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($productId) {
        $productController->viewProductDetails($productId);
        exit;
    } else {
        echo "<p>Error: Product ID not provided</p>";
    }
}

function handleDeclineOrder($orderController) {
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

function handleDefault($productController) {
    $products = $productController->getAllProducts();
    include(__DIR__ . '/../app/views/product/list.php');
}
