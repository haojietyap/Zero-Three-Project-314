<?php

require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/../Entity/User.php';

class UserRepository
{
    private mysqli $conn;
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) AS c FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return ((int)$result['c']) > 0;
    }

    // this function creates user
    public function createUser(string $name, string $email, string $password, string $role, string $status): bool
    {
        $sql = "INSERT INTO users (name, email, password, role, status)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $password, $role, $status);
        return $stmt->execute();
    }

    // this function will make new created user status be active
    public function createUserActive(string $name, string $email, string $password, string $role): bool
    {
        $sql = "INSERT INTO users (name, email, password, role, status)
                VALUES (?, ?, ?, ?, 'Active')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        return $stmt->execute();
    }
}
