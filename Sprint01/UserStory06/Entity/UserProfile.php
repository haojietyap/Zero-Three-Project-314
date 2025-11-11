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

    // create new user profile
    public function createUserProfile(string $profile_name, string $description): bool
    {
        $sql = "INSERT INTO user_profiles (profile_name, description)
                VALUES (:profile_name, :description)";
        $stmt = $this->conn->prepare($sql);
        try {
            return $stmt->execute([
                ':profile_name' => $profile_name,
                ':description'  => $description
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
