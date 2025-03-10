<?php

namespace App\Database;

use mysqli;
use Exception;

class Database {
    private $connection;

    public function __construct($host, $user, $password, $database) {
        $this->connection = new mysqli($host, $user, $password, $database);

        if ($this->connection->connect_error) {
            throw new Exception('Database connection failed: ' . $this->connection->connect_error);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);

        if ($params) {
            // Bind parameters dynamically
            $types = str_repeat('s', count($params)); // Assuming all parameters are strings
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt->error) {
            throw new Exception('Query error: ' . $stmt->error);
        }

        return $result;
    }

    public function close() {
        $this->connection->close();
    }
}
