<?php
require_once('../models/User.php');

class UserController {
    public function login() {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validate form data (ensure they're not empty)
            if (!empty($username) && !empty($password)) {
                // Instantiate User model
                $userModel = new User();

                // Attempt to authenticate user
                $user = $userModel->authenticateUser($username, $password);

                if ($user) {
                    // User authenticated, set session or cookie
                    // Redirect to user profile or dashboard
                    header("Location: profile.php");
                    exit;
                } else {
                    // Authentication failed, display error
                    $error = "Invalid username or password";
                }
            } else {
                $error = "Username and password are required";
            }
        }

        // Load the login view
        include('../views/user/login.php');
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
                $userModel = new User();

                // Check if username or email already exists
                $existingUser = $userModel->getUserByUsername($username);
                $existingEmail = $userModel->getUserByEmail($email);

                if ($existingUser || $existingEmail) {
                    $error = "Username or email already exists";
                } else {
                    // Create new user
                    $user = $userModel->createUser($username, $email, $password);

                    if ($user) {
                        // User created successfully, redirect to login page
                        header("Location: login.php");
                        exit;
                    } else {
                        $error = "Failed to create user";
                    }
                }
            } else {
                $error = "All fields are required";
            }
        }

        // Load the register view
        include('../views/user/register.php');
    }

    // Other user-related methods like profile update, logout, etc. can be added here...
}

