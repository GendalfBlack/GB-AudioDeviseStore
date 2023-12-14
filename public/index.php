<?php
// Start the session (if not started already)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Include the config file and controller
require_once(__DIR__ . '/../app/config.php');
require_once(__DIR__ . '/../app/controllers/ProductController.php');
require_once(__DIR__ . '/../app/controllers/UserController.php');

// Get the action parameter from the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Initialize the UserController
$userController = UserController::getInstance();
$productController = new ProductController();

// Route to appropriate controller action based on the action parameter
switch ($action) {
    case 'login':
        $userController->login();
        break;
    case 'register':
        $userController->register();
        break;
    case 'view_product':
        // Display product details based on the product ID
        $productId = isset($_GET['id']) ? $_GET['id'] : null;
        if ($productId) {
            $productController->viewProductDetails($productId);
            exit; // Stop further execution
        } else {
            echo "<p>Error: Product ID not provided</p>";
        }
        break;
    default:
        // Fetch and display all products on the main page
        $products = $productController->getAllProducts();
        include(__DIR__ . '/../app/views/product/list.php');
        break;
}
