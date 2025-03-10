<?php

namespace App\Controllers;

use App\Database\Database;

class UserController {
    private $db;

    public function __construct() {
        $config = require __DIR__ . '/../../config/config.php';
        $this->db = new Database(
            $config['db']['host'],
            $config['db']['user'],
            $config['db']['password'],
            $config['db']['name']
        );
    }

    public function createUser($username, $password, $email) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $this->db->query($sql, [$username, $hashedPassword, $email]);
        echo "User created successfully!";
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        $user = $result->fetch_assoc();
        return $user;
    }
}
