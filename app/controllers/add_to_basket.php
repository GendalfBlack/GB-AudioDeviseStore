<?php
require_once(__DIR__ . '/OrderController.php');
require_once(__DIR__ . '/../models/Order.php');
if(isset($_GET['back'])){
    header("Location: ../../public/index.php");
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle user authentication
    header("Location: ../public/index.php?action=login");
    exit;
}
$orderModel = Order::getInstance();

// Get the product ID from the URL parameter (assuming it's passed via GET)
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Assuming you have a method to fetch or create the user's order ID
    $orderId = $orderModel->getUserOrder($_SESSION['user_id']); // Replace with your actual method

    if (!$orderId) {
        // If the user doesn't have an existing order, create a new order
        $orderId = $orderModel->createOrder($_SESSION['user_id'],0);
    }

    // Now, add the product to the order (or order item)
    $quantity = 1; // Assuming the quantity is 1 for now

    // Check if the product is already in the order
    $existingItem = $orderModel->getOrderItem($productId,$orderId);

    if ($existingItem) {
        // If the product already exists in the order, update the quantity
        $newQuantity = $existingItem['quantity'] + $quantity;
        $orderModel->updateOrderItemQuantity($existingItem['order_item_id'], $newQuantity);
    } else {
        // If the product is not in the order, add it as a new order item
        $orderModel->addItemToBasket($orderId, $productId, $quantity);
    }
} else {
    echo "Product ID not provided.";
    exit;
}
$userId = $_SESSION['user_id'];
$orderController = OrderController::getInstance();
$basketItems = $orderController->getBasketItems($userId);

// Calculate total amount (if needed)
// ...

// Pass $basketItems and $totalAmount to the order view
include('../views/order/order_view.php');