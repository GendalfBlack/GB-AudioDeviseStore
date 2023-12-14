<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../models/Order.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (Order::getInstance()) {
        $orderId = Order::getInstance()->getUserOrder($_SESSION['user_id']);
        $success = Order::getInstance()->completeOrder($orderId);

        if ($success) {
            usleep(1000000);
            header("Location: ../../public/index.php");
            exit;
        } else {
            echo "Failed to complete the order. Please try again.";
        }
    } else {
        echo "Order ID not provided.";
    }
} else {
    echo "Invalid request method.";
}