<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../config.php');

class UserController {
    private static $instance = null; // Змінна для зберігання єдиного екземпляра класу

    private $showLoginLink; // Змінна для відображення посилання на вхід

    /** @var User */
    private $userModel; // Модель користувача

    public function __construct() {
        $this->showLoginLink = true; // Показувати посилання на вхід
        $this->userModel = User::getInstance(); // Отримання єдиного екземпляра моделі користувача
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new UserController();
        }
        return self::$instance;
    }

    public function login() {
        // Перевіряємо, чи була відправлена форма
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Отримуємо дані з форми
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Перевірка коректності заповнення форми
            if (!empty($username) && !empty($password)) {
                // Спроба аутентифікації користувача
                $user = $this->userModel->authenticateUser($username, $password);

                if ($user) {
                    $_SESSION['user_id'] = $user['user_id']; // Припускаємо, що ідентифікатор користувача отримується з бази даних під час аутентифікації

                    // Перенаправляємо користувача на сторінку профілю
                    $userController = new UserController();
                    $userController->viewProfile();
                    exit;
                } else {
                    // Аутентифікація не вдалася, виводимо помилку
                    $error = "Невірне ім'я користувача або пароль";
                }
            } else {
                $error = "Ім'я користувача та пароль є обов'язковими";
            }
        }
        include(__DIR__ . '/../views/user/login.php');
    }

    public function viewProfile() {
        // Припускаємо, що у моделі користувача є метод для отримання даних користувача за його ідентифікатором
        $userId = $_SESSION['user_id']; // Припускаємо, що ідентифікатор користувача зберігається в сесії
        $userData = $this->userModel->getUserById($userId); // Отримуємо дані користувача

        include(__DIR__ . '/../views/user/profile.php'); // Передаємо $userData у шаблон вигляду
        $this->showLoginLink = false; // Приховуємо посилання на вхід
    }

    public function decideShowLoginLink() {
        return $this->showLoginLink; // Повертаємо значення для відображення посилання на вхід
    }

    public function register() {
        // Перевіряємо, чи була відправлена форма
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Отримуємо дані з форми
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Перевірка коректності заповнення форми
            if (!empty($username) && !empty($email) && !empty($password)) {
                // Перевірка, чи існує користувач з таким ім'ям користувача або електронною поштою
                $existingUser = $this->userModel->getUserByUsername($username);
                $existingEmail = $this->userModel->getUserByEmail($email);

                if ($existingUser || $existingEmail) {
                    $error = "Користувач з таким ім'ям або електронною поштою вже існує";
                } else {
                    // Створення нового користувача
                    $user = $this->userModel->createUser($username, $email, $password);

                    if ($user) {
                        // Користувач успішно створений, перенаправляємо на сторінку входу
                        header("Location: ../public/index.php?action=login");
                        exit;
                    } else {
                        $error = "Не вдалося створити користувача";
                    }
                }
            } else {
                $error = "Всі поля обов'язкові для заповнення";
            }
        }
        include(__DIR__ . '/../views/user/register.php');
    }
}


