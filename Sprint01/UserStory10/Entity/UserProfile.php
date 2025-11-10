<?php
// Entity/UserProfile.php
require_once __DIR__ . '/../Database.php';

class UserProfile {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    /**
     * User Story #10
     * Search for user profiles by profile_name.
     * Returns an array of matching profiles (possibly empty).
     */
    public function searchUserProfile(string $profile_name): array {
        $sql = "SELECT profile_id, profile_name, description
                FROM user_profiles
                WHERE profile_name = :profile_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':profile_name' => $profile_name]);
        return $stmt->fetchAll();
    }
}
