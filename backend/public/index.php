<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\UserController;

$userController = new UserController();

// Crear un usuario
$userController->createUser('JohnDoe', 'password', 'john@example.com');

// Obtener un usuario por ID
$user = $userController->getUserById(1);
echo "User: " . print_r($user, true);
