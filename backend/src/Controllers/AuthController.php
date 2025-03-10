<?php

namespace App\Controllers;

use App\Services\SessionService;

class AuthController {
    private $sessionService;

    public function __construct() {
        $this->sessionService = new SessionService();
    }

    public function login($username, $password) {
        // Simulate user authentication
        if ($username === 'JohnDoe' && $password === 'password') {
            $this->sessionService->set('user', ['id' => 1, 'username' => $username]);
            echo "Login successful!";
        } else {
            echo "Invalid credentials.";
        }
    }

    public function getUser() {
        $user = $this->sessionService->get('user');
        return $user ? $user : "No user logged in.";
    }
}
