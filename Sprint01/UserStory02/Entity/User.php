<?php

declare(strict_types=1);

class User
{
    public int $id = 0;
    public string $name = '';
    public string $email = '';
    public string $role = '';
    public string $status = '';

    public static function fromRow(array $row): User
    {
        $u = new self();
        $u->id     = (int)($row['userID'] ?? 0);
        $u->name   = (string)($row['name']   ?? '');
        $u->email  = (string)($row['email']  ?? '');
        $u->role   = (string)($row['role']   ?? '');
        $u->status = (string)($row['status'] ?? '');
        return $u;
    }

    /**
     *
     * this returns an array<User> (empty array if query fails).
     */
    public static function fetchAll(mysqli $conn): array
    {
        $sql = "SELECT userID, name, email, role, status
                FROM users
                ORDER BY userID ASC";

        $result = $conn->query($sql);
        if ($result === false) {
            return [];
        }

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = self::fromRow($row);
        }
        $result->free();
        return $users;
    }
}
