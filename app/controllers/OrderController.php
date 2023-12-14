<?php
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../config.php');

class OrderController {
    private static $instance = null;
    /** @var Order */
    private $orderModel;

    public function __construct() {
        $this->orderModel = Order::getInstance();
    }
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new OrderController();
        }
        return self::$instance;
    }
    public function getBasketItems($userId) {
        $orderId = $this->orderModel->getUserOrder($userId);
        return $this->orderModel->getBasketItems($userId, $orderId);
    }
    public function addItemToBasket($userId, $productId, $quantity)
    {
        $orderId = $this->orderModel->getUserOrder($userId);
        $existingItem = $this->orderModel->getOrderItem($productId, $orderId);

        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $quantity;
            return $this->orderModel->updateOrderItemQuantity($existingItem['order_item_id'], $newQuantity);
        } else {
            return $this->orderModel->createOrderItem($orderId, $productId, $quantity);
        }
    }
}

