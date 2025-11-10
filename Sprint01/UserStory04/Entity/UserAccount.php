<?php

require_once __DIR__ . '/../Database.php';

class UserAccount
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // suspend a user by email
    public function suspendUserAccount(string $email): bool
    {
        $sql = "UPDATE users SET status = 'SUSPENDED' WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        try {
            return $stmt->execute([':email' => $email]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
