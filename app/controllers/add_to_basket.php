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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['action'])) {
    $productId = $_POST['product_id'];
    $action = $_POST['action'];

    $orderId = $orderModel->getUserOrder($_SESSION['user_id']);

    if (!$orderId) {
        $orderId = $orderModel->createOrder($_SESSION['user_id'], 0);
    }

    $quantity = 1;

    $existingItem = $orderModel->getOrderItem($productId, $orderId);

    if ($existingItem) {
        $newQuantity = $existingItem['quantity'];

        if ($action === 'increment') {
            $newQuantity += $quantity;
        } elseif ($action === 'decrement' && $newQuantity > 1) {
            $newQuantity -= $quantity;
        } elseif ($action === 'decrement' && $newQuantity === 1) {
            $newQuantity = 0;
            if ($orderModel->removeOrderItem($existingItem['order_item_id'])) {
                header("Location: add_to_basket.php");
                exit;
            } else {
                echo "Failed to remove the order item.";
            }
        }

        $orderModel->updateOrderItemQuantity($existingItem['order_item_id'], $newQuantity);
    } else {
        $orderController->addItemToBasket($_SESSION['user_id'], $productId, $quantity);
    }
}

include('../views/order/order_view.php');