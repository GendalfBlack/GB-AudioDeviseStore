<?php
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../config.php');

class OrderController {
    private static $instance = null; // Змінна для зберігання єдиного екземпляра класу

    /** @var Order */
    private $orderModel; // Модель замовлення

    public function __construct() {
        $this->orderModel = Order::getInstance(); // Отримання єдиного екземпляра моделі замовлення
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new OrderController();
        }
        return self::$instance;
    }

    public function getBasketItems($userId) {
        $orderId = $this->orderModel->getUserOrder($userId); // Отримання ідентифікатора замовлення користувача
        return $this->orderModel->getBasketItems($userId, $orderId); // Отримання товарів у кошику користувача
    }

    public function addItemToBasket($userId, $productId, $quantity)
    {
        $orderId = $this->orderModel->getUserOrder($userId); // Отримання ідентифікатора замовлення користувача
        $existingItem = $this->orderModel->getOrderItem($productId, $orderId); // Перевірка наявності товару у замовленні

        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $quantity; // Обновлення кількості товару
            return $this->orderModel->updateOrderItemQuantity($existingItem['order_item_id'], $newQuantity); // Оновлення кількості товару у замовленні
        } else {
            return $this->orderModel->createOrderItem($orderId, $productId, $quantity); // Додавання нового товару у замовлення
        }
    }

    public function declineOrder($orderId)
    {
        return $this->orderModel->declineOrder($orderId); // Відхилення замовлення
    }

    public function getUserOrder($userId)
    {
        return $this->orderModel->getUserOrder($userId); // Отримання замовлення користувача
    }
}


