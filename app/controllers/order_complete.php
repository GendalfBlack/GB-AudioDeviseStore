<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../models/Order.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (Order::getInstance()) {
        $orderId = Order::getInstance()->getUserOrder($_SESSION['user_id']);
        // Update the order status to "finished" in the database
        $success = Order::getInstance()->completeOrder($orderId); // Replace with your function to update the order status

        if ($success) {
            echo "Order completed successfully!";
            usleep(1000000);
            header("Location: add_to_basket.php?back=1");
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