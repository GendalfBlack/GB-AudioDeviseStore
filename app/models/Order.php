<?php
require_once(__DIR__ . '/../config.php');

class Order
{
    private static $instance; // Змінна для зберігання єдиного екземпляра класу

    private $db; // Змінна для підключення до бази даних

    public function __construct()
    {
        // Встановлюємо з'єднання з базою даних при створенні об'єкта
        $this->db = new PDO(DB_CONNECTION, DB_USER, DB_PASSWORD);
        // Встановлюємо режим викидання винятків для об'єкту PDO
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        // Перевіряємо, чи вже існує екземпляр класу
        if (!self::$instance) {
            // Якщо екземпляр класу ще не створений, створюємо його
            self::$instance = new Order();
        }
        // Повертаємо єдиний екземпляр класу
        return self::$instance;
    }


    public function createOrder($user_id, $total_amount, $finished = false)
    {
        // Формуємо SQL-запит для вставки нового запису в таблицю Orders
        $query = "INSERT INTO Orders (user_id, total_amount, finished) VALUES (:user_id, :total_amount, :finished)";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $user_id до підготовленого оператора
        $stmt->bindParam(':user_id', $user_id);
        // Прив'язуємо значення параметра $total_amount до підготовленого оператора
        $stmt->bindParam(':total_amount', $total_amount);
        // Прив'язуємо значення параметра $finished до підготовленого оператора,
        // вказуючи, що це булевий тип даних
        $stmt->bindParam(':finished', $finished, PDO::PARAM_BOOL);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();
        // Отримуємо результат запиту, отримуємо перший рядок результату в асоціативному масиві
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Повертаємо order_id (ідентифікатор замовлення), якщо результат не є пустим і містить ключ order_id,
        // в іншому випадку повертаємо null
        return ($result !== false && isset($result['order_id'])) ? $result['order_id'] : null;
    }

    public function getUserOrder($user_id)
    {
        // Формуємо SQL-запит для вибору ідентифікатора замовлення з таблиці orders,
        // де user_id співпадає з переданим значенням і finished = false
        $query = "SELECT order_id FROM orders WHERE user_id = :user_id AND finished = false";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $user_id до підготовленого оператора
        $stmt->bindParam(':user_id', $user_id);

        // Виконуємо підготовлений SQL-запит
        $stmt->execute();
        // Отримуємо результат запиту, отримуємо перший рядок результату в асоціативному масиві
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Повертаємо order_id (ідентифікатор замовлення), якщо результат не є пустим і містить ключ order_id,
        // в іншому випадку повертаємо null
        return ($result !== false && isset($result['order_id'])) ? $result['order_id'] : null;
    }

    public function getOrderItem($product_id, $order_id)
    {
        // Формуємо SQL-запит для вибору всіх даних про товар з таблиці order_items,
        // де product_id співпадає з переданим значенням і order_id співпадає з переданим значенням
        $query = "SELECT * FROM order_items WHERE product_id = :product_id AND order_id = :order_id";

        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $product_id до підготовленого оператора
        $stmt->bindParam(':product_id', $product_id);
        // Прив'язуємо значення параметра $order_id до підготовленого оператора
        $stmt->bindParam(':order_id', $order_id);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();

        // Повертаємо асоціативний масив з даними про замовлення,
        // якщо результат не є пустим, інакше повертаємо null
        return $stmt->fetch(PDO::FETCH_ASSOC); // Повертаємо отриманий товар замовлення
    }


    public function updateOrderItemQuantity($orderItemId, $newQuantity)
    {
        // Формуємо SQL-запит для оновлення кількості товару в таблиці order_items,
        // де order_item_id співпадає з переданим значенням
        $query = "UPDATE order_items SET quantity = :new_quantity WHERE order_item_id = :order_item_id";

        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $newQuantity до підготовленого оператора
        $stmt->bindParam(':new_quantity', $newQuantity);
        // Прив'язуємо значення параметра $orderItemId до підготовленого оператора
        $stmt->bindParam(':order_item_id', $orderItemId);

        // Виконуємо підготовлений SQL-запит і повертаємо результат виконання
        return $stmt->execute();
    }

    public function removeOrderItem($orderItemId)
    {
        try {
            // Формуємо SQL-запит для видалення товару з таблиці order_items,
            // де order_item_id співпадає з переданим значенням
            $query = "DELETE FROM order_items WHERE order_item_id = :order_item_id";
            // Підготовлюємо SQL-запит
            $stmt = $this->db->prepare($query);
            // Прив'язуємо значення параметра $orderItemId до підготовленого оператора
            $stmt->bindParam(':order_item_id', $orderItemId);
            // Виконуємо підготовлений SQL-запит і повертаємо результат виконання
            return $stmt->execute();
        } catch (PDOException $e) {
            // В разі виникнення помилки повертаємо false
            return false;
        }
    }

    public function createOrderItem($orderId, $productId, $quantity)
    {
        // Формуємо SQL-запит для вставки нового запису про товар в таблицю order_items
        $query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";

        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметрів $orderId, $productId та $quantity до підготовленого оператора
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);

        // Виконуємо підготовлений SQL-запит і повертаємо результат виконання
        return $stmt->execute();
    }


    public function getBasketItems($user_id, $order_id)
    {
        // Формуємо SQL-запит для отримання даних про товари в кошику,
        // використовуючи з'єднання таблиць order_items, Products та Orders
        $query = "SELECT order_items.*, Products.product_name, Products.price 
              FROM order_items
              JOIN Products ON order_items.product_id = Products.product_id 
              JOIN Orders ON order_items.order_id = Orders.order_id 
              WHERE Orders.user_id = :user_id AND Orders.order_id = :order_id";

        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметрів $user_id та $order_id до підготовленого оператора
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_id', $order_id);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();

        // Повертаємо всі рядки результату запиту у вигляді асоціативного масиву
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function completeOrder($orderId)
    {
        try {
            // Формуємо SQL-запит для оновлення статусу замовлення на завершений та розрахунку загальної суми замовлення
            $query = "UPDATE orders 
                  SET finished = true, 
                      total_amount = (SELECT SUM(p.price * oi.quantity) 
                                      FROM order_items oi 
                                      JOIN products p ON oi.product_id = p.product_id 
                                      WHERE oi.order_id = :order_id) 
                  WHERE order_id = :order_id";
            // Підготовлюємо SQL-запит
            $stmt = $this->db->prepare($query);
            // Прив'язуємо значення параметра $orderId до підготовленого оператора
            $stmt->bindParam(':order_id', $orderId);
            // Виконуємо підготовлений SQL-запит
            $stmt->execute();
            // Очищаємо кеш для класу Order
            Order::$instance = null;
            // Повертаємо true, якщо операція успішна
            return true;
        } catch (PDOException $e) {
            // В разі виникнення помилки повертаємо false
            return false;
        }
    }

    public function declineOrder($orderId)
    {
        try {
            // Видаляємо усі товари замовлення
            $deleteQuery = "DELETE FROM order_items WHERE order_id = :order_id";
            $deleteStmt = $this->db->prepare($deleteQuery);
            $deleteStmt->bindParam(':order_id', $orderId);
            $deleteStmt->execute();

            // Оновлюємо статус замовлення на відхилено
            $updateQuery = "UPDATE orders SET finished = true WHERE order_id = :order_id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(':order_id', $orderId);
            $updateStmt->execute();

            // Очищаємо кеш для класу Order
            Order::$instance = null;
            // Повертаємо true, якщо операція успішна
            return true;
        } catch (PDOException $e) {
            // В разі виникнення помилки повертаємо false
            return false;
        }
    }

}
