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


    // update an existing user profile (role) identified by profile_id.
    // Returns true only if at least one row was updated.

    public function updateUserProfile(int $profile_id, string $profile_name, string $description): bool
    {
        $sql = "UPDATE user_profiles
                SET profile_name = :profile_name,
                    description  = :description
                WHERE profile_id = :profile_id";
        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute([
                ':profile_name' => $profile_name,
                ':description'  => $description,
                ':profile_id'   => $profile_id
            ]);

            // if no rows were affected, the profile_id probably does not exist
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {

            return false;
        }
    }
}
