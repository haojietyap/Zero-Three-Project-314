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


    // suspend an existing user profile (set status = 'SUSPENDED').
    // returns true only if at least one row was updated.

    public function suspendUserProfile(int $profile_id): bool
    {
        $sql = "UPDATE user_profiles
                SET status = 'SUSPENDED'
                WHERE profile_id = :profile_id";
        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute([
                ':profile_id'   => $profile_id
            ]);

            // if no rows were affected, the profile_id probably does not exist
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // in a real system you might log this error
            return false;
        }
    }
}
