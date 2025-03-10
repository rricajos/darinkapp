<?php
$host = '96ff0q.stackhero-network.com';
$user = 'root';
$password = 'vSCdv2YMI2vCcIs2zKuFEds4U2ZNxodP';
$database = 'test';

try {
    $mysqli = new mysqli($host, $user, $password, $database);
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    echo "Connected successfully to the database.";
    $mysqli->close();
} catch (Exception $e) {
    echo $e->getMessage();
}
