<?php
require_once(__DIR__ . '/../config.php');

class Product {
    private $db; // Змінна для підключення до бази даних

    public function __construct() {
        // Встановлюємо з'єднання з базою даних при створенні об'єкта
        $this->db = new PDO(DB_CONNECTION, DB_USER, DB_PASSWORD);
        // Встановлюємо режим викидання винятків для об'єкту PDO
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getProductById($productId) {
        // Формуємо SQL-запит для отримання даних про продукт за його ідентифікатором
        $query = "SELECT Products.*, Categories.category_name  
                  FROM Products 
                  JOIN Categories ON Products.category_id = Categories.category_id
                  WHERE product_id = :product_id";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $productId до підготовленого оператора
        $stmt->bindParam(':product_id', $productId);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();

        // Повертаємо асоціативний масив з даними про продукт
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllProducts() {
        // Формуємо SQL-запит для отримання всіх продуктів разом з їх категоріями
        $query = "SELECT Products.*, Categories.category_name 
                  FROM Products 
                  JOIN Categories ON Products.category_id = Categories.category_id";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();

        // Повертаємо всі рядки результату запиту у вигляді асоціативного масиву
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

