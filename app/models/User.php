<?php
require_once(__DIR__ . '/../config.php');

class User {
    private static $instance = null; // Змінна для зберігання єдиного екземпляра класу

    private $db; // Змінна для підключення до бази даних

    public function __construct() {
        // Встановлюємо з'єднання з базою даних при створенні об'єкта
        $this->db = new PDO(DB_CONNECTION, DB_USER, DB_PASSWORD);
        // Встановлюємо режим викидання винятків для об'єкту PDO
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        // Перевіряємо, чи вже існує екземпляр класу
        if (!self::$instance) {
            // Якщо екземпляр класу ще не створений, створюємо його
            self::$instance = new User();
        }
        // Повертаємо єдиний екземпляр класу
        return self::$instance;
    }

    public function authenticateUser($username, $password) {
        // Формуємо SQL-запит для аутентифікації користувача
        $query = "SELECT * FROM Users WHERE username = :username AND password = :password";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметрів $username та $password до підготовленого оператора
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();
        // Повертаємо асоціативний масив з даними про користувача
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $email, $password) {
        // Формуємо SQL-запит для створення нового користувача
        $query = "INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметрів $username, $email та $password до підготовленого оператора
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        // Виконуємо підготовлений SQL-запит і повертаємо результат виконання
        return $stmt->execute();
    }

    public function getUserByUsername($username) {
        // Формуємо SQL-запит для отримання даних про користувача за його ім'ям користувача
        $query = "SELECT * FROM Users WHERE username = :username";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $username до підготовленого оператора
        $stmt->bindParam(':username', $username);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();
        // Повертаємо асоціативний масив з даними про користувача
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        // Формуємо SQL-запит для отримання даних про користувача за його email
        $query = "SELECT * FROM Users WHERE email = :email";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $email до підготовленого оператора
        $stmt->bindParam(':email', $email);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();
        // Повертаємо асоціативний масив з даними про користувача
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($userId) {
        // Формуємо SQL-запит для отримання даних про користувача за його ідентифікатором
        $query = "SELECT * FROM Users WHERE user_id = :user_id";
        // Підготовлюємо SQL-запит
        $stmt = $this->db->prepare($query);
        // Прив'язуємо значення параметра $userId до підготовленого оператора
        $stmt->bindParam(':user_id', $userId);
        // Виконуємо підготовлений SQL-запит
        $stmt->execute();
        // Повертаємо асоціативний масив з даними про користувача
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


