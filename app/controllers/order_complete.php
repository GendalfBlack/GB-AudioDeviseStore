<?php
// Перевірка наявності сесії
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Підключення моделі замовлення
require_once(__DIR__ . '/../models/Order.php');

// Обробка POST-запиту
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Перевірка існування екземпляра моделі замовлення
    if (Order::getInstance()) {
        // Отримання ідентифікатора замовлення користувача
        $orderId = Order::getInstance()->getUserOrder($_SESSION['user_id']);

        // Завершення замовлення
        $success = Order::getInstance()->completeOrder($orderId);

        if ($success) {
            usleep(1000000);
            header("Location: ../../public/index.php");
            exit;
        } else {
            echo "Не вдалося завершити замовлення. Будь ласка, спробуйте ще раз.";
        }
    } else {
        echo "Не наданий ідентифікатор замовлення.";
    }
} else {
    echo "Недійсний метод запиту.";
}
