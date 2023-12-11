<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../config.php');

class UserController {
    private static $instance = null;
    private $showLoginLink;
    /** @var User */
    private $userModel;

    public function __construct() {
        $this->showLoginLink = true;
        $this->userModel = User::getInstance(); // Get the instance of User model
    }
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new UserController();
        }
        return self::$instance;
    }
    public function login() {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validate form data (ensure they're not empty)
            if (!empty($username) && !empty($password)) {
                // Instantiate User model


                // Attempt to authenticate user
                $user = $this->userModel->authenticateUser($username, $password);

                if ($user) {
                    $_SESSION['user_id'] = $user['user_id']; // Assuming user ID is retrieved from the database during authentication

                    // Redirect user to profile page
                    $userController = new UserController();
                    $userController->viewProfile();
                    exit;
                } else {
                    // Authentication failed, display error
                    $error = "Invalid username or password";
                }
            } else {
                $error = "Username and password are required";
            }
        }
        include(__DIR__ . '/../views/user/login.php');
    }
    public function viewProfile() {
        // Assume you have a method in your User model to get user data by ID
        $userId = $_SESSION['user_id']; // Assuming you store user ID in the session
        $userData = $this->userModel->getUserById($userId); // Retrieve user data

        include(__DIR__ . '/../views/user/profile.php'); // Pass $userData to the view
        $this->showLoginLink = false;
    }
    public function decideShowLoginLink() {
        return $this->showLoginLink;
    }
    public function register() {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate form data (ensure they're not empty)
            if (!empty($username) && !empty($email) && !empty($password)) {
                // Instantiate User model
                // Check if username or email already exists
                $existingUser = $this->userModel->getUserByUsername($username);
                $existingEmail = $this->userModel->getUserByEmail($email);

                if ($existingUser || $existingEmail) {
                    $error = "Username or email already exists";
                } else {
                    // Create new user
                    $user = $this->userModel->createUser($username, $email, $password);

                    if ($user) {
                        // User created successfully, redirect to login page
                        header("Location: ../public/index.php?action=login");
                        exit;
                    } else {
                        $error = "Failed to create user";
                    }
                }
            } else {
                $error = "All fields are required";
            }
        }
        include(__DIR__ . '/../views/user/register.php');
    }
}

