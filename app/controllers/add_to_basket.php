<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/OrderController.php');
require_once(__DIR__ . '/../models/Order.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: /MySite/public/index.php?action=login");
    exit;
}
$orderModel = Order::getInstance();
$orderController = OrderController::getInstance();

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    $orderId = $orderModel->getUserOrder($_SESSION['user_id']);

    if (!$orderId) {
        $orderId = $orderModel->createOrder($_SESSION['user_id'],0);
    }

    $quantity = 1;

    $existingItem = $orderModel->getOrderItem($productId,$orderId);

    if ($existingItem) {
        $newQuantity = $existingItem['quantity'] + $quantity;
        $orderModel->updateOrderItemQuantity($existingItem['order_item_id'], $newQuantity);
    } else {
        $orderController->addItemToBasket($_SESSION['user_id'], $productId, $quantity);
    }
} else {
    echo "Product ID not provided.";
    exit;
}

include('../views/order/order_view.php');