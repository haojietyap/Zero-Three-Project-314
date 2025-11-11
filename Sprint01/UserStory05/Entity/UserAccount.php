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

    // search user by email and return details or null
    public function searchUserAccount(string $email): ?array
    {
        $sql = "SELECT u.user_id,
                       u.username,
                       u.email,
                       u.phone,
                       u.profile_id,
                       u.status,
                       p.profile_name
                FROM users u
                LEFT JOIN user_profiles p ON u.profile_id = p.profile_id
                WHERE u.email = :email
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row !== false ? $row : null;
    }
}
