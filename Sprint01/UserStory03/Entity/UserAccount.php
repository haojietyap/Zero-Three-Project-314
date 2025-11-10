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

    public function updateUserAccount(string $email, string $field, string $newValue): bool
    {
        $map = [
            'username' => 'username',
            'email'    => 'email',
            'phone'    => 'phone',
            'role'     => 'profile_id',
            'status'   => 'status',
            'password' => 'password_hash'
        ];

        if (!isset($map[$field])) {
            return false;
        }

        $column = $map[$field];

        if ($column == 'password_hash') {
            $newValue = password_hash($newValue, PASSWORD_DEFAULT);
        } elseif ($column == 'profile_id') {
            $newValue = (int)$newValue;
        } elseif ($column == 'status') {
            $newValue = (strtoupper($newValue) === 'SUSPENDED') ? 'SUSPENDED' : 'ACTIVE';
        }

        $sql = "UPDATE users SET {$column} = :value WHERE email = :email";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute([':value' => $newValue, ':email' => $email]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
