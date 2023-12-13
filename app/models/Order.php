<?php
require_once(__DIR__ . '/../config.php');

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO(DB_CONNECTION, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function createOrder($user_id, $total_amount)
    {
        $query = "INSERT INTO Orders (user_id, total_amount) VALUES (:user_id, :total_amount)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':total_amount', $total_amount);

        return $stmt->execute(); // Returns true if order creation is successful, otherwise false
    }

    public function getOrderById($order_id)
    {
        $query = "SELECT * FROM Orders WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns order details or false if not found
    }

    public function getUserOrders($user_id)
    {
        $query = "SELECT * FROM Orders WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns array of user's orders or empty array if none found
    }
    // Add methods here to handle orders, such as createOrder(), getOrderById(), etc.
}
