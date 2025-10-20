<?php

require_once __DIR__ . '/../Database/db_connect.php';

class User
{
    private mysqli $conn;

    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $role;
    public string $status;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // this function wiil create new user
    public function create(string $name, string $email, string $password, string $role): bool
    {
        $sql = "INSERT INTO users (name, email, password, role, status)
                VALUES (?, ?, ?, ?, 'Active')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        return $stmt->execute();
    }

    // this function checks if email already exists
    public function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) AS c FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return ((int)$res['c']) > 0;
    }
}
