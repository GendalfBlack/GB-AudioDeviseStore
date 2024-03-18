<?php
// Перевірка наявності сесії
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Підключення контролера замовлень та моделі замовлення
require_once(__DIR__ . '/OrderController.php');
require_once(__DIR__ . '/../models/Order.php');

// Перенаправлення на сторінку входу, якщо користувач не увійшов у систему
if (!isset($_SESSION['user_id'])) {
    header("Location: /MySite/public/index.php?action=login");
    exit;
}

// Отримання єдиного екземпляра моделі замовлення та контролера замовлень
$orderModel = Order::getInstance();
$orderController = OrderController::getInstance();

// Обробка POST-запиту
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['action'])) {
    $productId = $_POST['product_id'];
    $action = $_POST['action'];

    // Отримання ідентифікатора замовлення користувача
    $orderId = $orderModel->getUserOrder($_SESSION['user_id']);

    // Створення нового замовлення, якщо воно не існує
    if (!$orderId) {
        $orderId = $orderModel->createOrder($_SESSION['user_id'], 0);
    }

    $quantity = 1;

    // Перевірка наявності товару у замовленні
    $existingItem = $orderModel->getOrderItem($productId, $orderId);

    if ($existingItem) {
        $newQuantity = $existingItem['quantity'];

        // Збільшення кількості товару
        if ($action === 'increment') {
            $newQuantity += $quantity;
        }
        // Зменшення кількості товару
        elseif ($action === 'decrement' && $newQuantity > 1) {
            $newQuantity -= $quantity;
        }
        // Видалення товару зі зменшенням кількості до 0
        elseif ($action === 'decrement' && $newQuantity === 1) {
            $newQuantity = 0;
            if ($orderModel->removeOrderItem($existingItem['order_item_id'])) {
                header("Location: add_to_basket.php");
                exit;
            } else {
                echo "Не вдалося видалити товар замовлення.";
            }
        }

        // Оновлення кількості товару у замовленні
        $orderModel->updateOrderItemQuantity($existingItem['order_item_id'], $newQuantity);
    } else {
        // Додавання нового товару у замовлення
        $orderController->addItemToBasket($_SESSION['user_id'], $productId, $quantity);
    }
}

// Підключення файлу вигляду для перегляду замовлення
include('../views/order/order_view.php');
