<?php
require_once(__DIR__ . '/../config.php');

class Order
{
    private static $instance;
    private $db;

    public function __construct()
    {
        $this->db = new PDO(DB_CONNECTION, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Order();
        }
        return self::$instance;
    }

    public function createOrder($user_id, $total_amount, $finished = false)
    {
        $query = "INSERT INTO Orders (user_id, total_amount, finished) VALUES (:user_id, :total_amount, :finished)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':finished', $finished, PDO::PARAM_BOOL);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result !== false && isset($result['order_id'])) ? $result['order_id'] : null;
    }

    public function getUserOrder($user_id)
    {
        $query = "SELECT order_id FROM orders WHERE user_id = :user_id AND finished = false";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result !== false && isset($result['order_id'])) ? $result['order_id'] : null;
    }

    public function getOrderItem($product_id,$order_id)
    {
        $query = "SELECT * FROM order_items WHERE product_id = :product_id AND order_id = :order_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Return the fetched order item
    }

    public function updateOrderItemQuantity($orderItemId, $newQuantity)
    {
        $query = "UPDATE order_items SET quantity = :new_quantity WHERE order_item_id = :order_item_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':new_quantity', $newQuantity);
        $stmt->bindParam(':order_item_id', $orderItemId);

        return $stmt->execute();
    }
    public function removeOrderItem($orderItemId)
    {
        try {
            $query = "DELETE FROM order_items WHERE order_item_id = :order_item_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_item_id', $orderItemId);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    public function createOrderItem($orderId, $productId, $quantity)
    {
        $query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);

        return $stmt->execute();
    }

    public function getBasketItems($user_id, $order_id)
    {
        $query = "SELECT order_items.*, Products.product_name, Products.price 
              FROM order_items
              JOIN Products ON order_items.product_id = Products.product_id 
              JOIN Orders ON order_items.order_id = Orders.order_id 
              WHERE Orders.user_id = :user_id AND Orders.order_id = :order_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function completeOrder($orderId)
    {
        try {
            $query = "UPDATE orders 
                      SET finished = true, 
                          total_amount = (SELECT SUM(p.price * oi.quantity) 
                                          FROM order_items oi 
                                          JOIN products p ON oi.product_id = p.product_id 
                                          WHERE oi.order_id = :order_id) 
                      WHERE order_id = :order_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->execute();
            Order::$instance = null;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function declineOrder($orderId)
    {
        try {
            $deleteQuery = "DELETE FROM order_items WHERE order_id = :order_id";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->bindParam(':order_id', $orderId);
            $deleteStmt->execute();

            $updateQuery = "UPDATE orders SET finished = true WHERE order_id = :order_id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(':order_id', $orderId);
            $updateStmt->execute();

            Order::$instance = null;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
