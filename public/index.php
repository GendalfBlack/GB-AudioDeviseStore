<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../app/config.php');
require_once(__DIR__ . '/../app/controllers/ProductController.php');
require_once(__DIR__ . '/../app/controllers/UserController.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

$userController = UserController::getInstance();
$productController = new ProductController();

switch ($action) {
    case 'login':
        $userController->login();
        break;
    case 'register':
        $userController->register();
        break;
    case 'view_product':
        $productId = isset($_GET['id']) ? $_GET['id'] : null;
        if ($productId) {
            $productController->viewProductDetails($productId);
            exit;
        } else {
            echo "<p>Error: Product ID not provided</p>";
        }
        break;
    default:
        $products = $productController->getAllProducts();
        include(__DIR__ . '/../app/views/product/list.php');
        break;
}
