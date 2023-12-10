<?php
require_once(__DIR__ . '/../config.php');

class User {
    private $db;

    public function __construct() {
        $this->db = new PDO(DB_CONNECTION, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function authenticateUser($username, $password) {
        $query = "SELECT * FROM Users WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password); // For actual usage, use password hashing

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user details if authenticated, otherwise false
    }

    public function createUser($username, $email, $password) {
        $query = "INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password); // For actual usage, use password hashing

        return $stmt->execute(); // Returns true if user creation is successful, otherwise false
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user details or false if not found
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM Users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user details or false if not found
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM Users WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user details or false if not found
    }
}

