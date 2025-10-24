<?php

require_once __DIR__ . '/db_connect.php';
require_once __DIR__ . '/../Entity/User.php';

class UserRepository
{
    private mysqli $conn;
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function findByEmail(string $email): ?User
    {
        $sql = "SELECT userID, name, email, password, role, status
                FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row ? new User($row) : null;
    }

    /**
     * if it returns,
     * 
     *   ['state'=>'ok', 'user'=>User] on success
     *   ['state'=>'inactive'] if status is Inactive
     *   ['state'=>'invalid'] if email/password mismatch
     */
    public function verifyCredentials(string $email, string $plainPassword): array
    {
        $user = $this->findByEmail($email);
        if (!$user) return ['state' => 'invalid'];
        if ($user->isInactive()) return ['state' => 'inactive'];


        if ($plainPassword !== $user->password) return ['state' => 'invalid'];

        return ['state' => 'ok', 'user' => $user];
    }
}
