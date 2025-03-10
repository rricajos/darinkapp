<?php

namespace App\Models;

class User {
    public function create($data) {
        // Save the user to the database
        // Example: $db->insert('users', $data);
    }

    public function find($userId) {
        // Fetch user by ID from the database
        return ['id' => $userId, 'username' => 'JohnDoe'];
    }

    public function findByUsername($username) {
        // Fetch user by username from the database
        return ['id' => 1, 'username' => $username, 'password' => password_hash('password', PASSWORD_BCRYPT)];
    }
}
