<?php
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../config.php');

class OrderController {
    private static $instance = null;
    /** @var Order */
    private $orderModel;

    public function __construct() {
        $this->orderModel = new Order();
    }
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new OrderController();
        }
        return self::$instance;
    }
    public function getBasketItems($userId) {
        // Logic to fetch basket items for the given user ID from the Order model
        $order_id = Order::getInstance()->getUserOrder($userId);
        return $this->orderModel->getBasketItems($userId, $order_id);
    }

// Additional methods like updating orders, deleting orders, etc. can be added here
}

