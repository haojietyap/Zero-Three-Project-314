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

    public function viewUserAccountData(): array
    {
        $sql = "SELECT u.user_id, u.username, u.email, u.phone, u.status, p.profile_name
                FROM users u
                JOIN user_profiles p ON u.profile_id = p.profile_id
                ORDER BY u.user_id ASC";

        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}
