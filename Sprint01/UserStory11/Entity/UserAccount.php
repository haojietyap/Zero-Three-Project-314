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



    //validates that a user with the given email, password and profile_id exists
    //and is ACTIVE (if the status column is present).

    public function validateAccount(string $email, string $password, int $profile_id): bool
    {
        $sql = "SELECT user_id, email, password_hash, status, profile_id
                FROM users
                WHERE email = :email
                  AND profile_id = :profile_id
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':email'      => $email,
            ':profile_id' => $profile_id
        ]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        // check password
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        // status check if column exists
        if (isset($user['status']) && strtoupper($user['status']) !== 'ACTIVE') {
            return false;
        }

        return true;
    }
}
