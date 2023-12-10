<?php
// Start the session (if not started already)
session_start();

// Include the config file and controller
require_once(__DIR__ . '/../app/config.php');
require_once(__DIR__ . '/../app/controllers/UserController.php');

// Get the action parameter from the URL
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Initialize the UserController
$userController = new UserController();

// Route to appropriate controller action based on the action parameter
switch ($action) {
    case 'login':
        $userController->login();
        break;
    case 'register':
        $userController->register();
        break;
    default:
        echo "<p>Error 404</p>>";
        // Default action (e.g., display homepage or other default content)
        // For example:
        // include('views/home.php');
        break;
}
