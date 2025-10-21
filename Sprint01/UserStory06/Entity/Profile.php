<?php

declare(strict_types=1);

class Profile
{
    // this keeps the list in sync with your ENUM in db_connect.php
    private static array $allowedRoles = ['User Admin', 'CSR Rep', 'PIN', 'Platform Manager'];

    /** this return the allowed roles (matches ENUM constraint). */
    public static function allowedRoles(): array
    {
        return self::$allowedRoles;
    }

    /** this checks if a role already exists in the profiles table. */
    public static function existsByRole(\mysqli $conn, string $role): bool
    {
        $sql = "SELECT COUNT(*) AS c FROM profiles WHERE role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $role);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return ((int)$row['c']) > 0;
    }

    /**
     * this creates a profile row (role + permissions + description).
     * Returns true on success.
     */
    public static function create(\mysqli $conn, string $role, string $permissions, string $description): bool
    {
        $sql = "INSERT INTO profiles (role, permissions, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $role, $permissions, $description);
        return $stmt->execute();
    }
}
