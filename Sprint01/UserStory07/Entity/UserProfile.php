<?php

require_once __DIR__ . '/../Database.php';

class UserProfile
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // view all user profiles
    public function viewUserProfiles(): array
    {
        $sql = "SELECT profile_id, profile_name, description FROM user_profiles ORDER BY profile_id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows !== false ? $rows : [];
    }
}
