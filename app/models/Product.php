<?php
require_once(__DIR__ . '/../config.php');

class Product {
    private $db;

    public function __construct() {
        $this->db = new PDO(DB_CONNECTION, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getProductById($productId) {
        $query = "SELECT Products.*, Categories.category_name  
                  FROM Products 
                  JOIN Categories ON Products.category_id = Categories.category_id
                  WHERE product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllProducts() {
        $query = "  SELECT Products.*, Categories.category_name 
                    FROM Products 
                    JOIN Categories ON Products.category_id = Categories.category_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
