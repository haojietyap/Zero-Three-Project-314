<?php

declare(strict_types=1);

class User
{
    public int $id = 0;
    public string $name = '';
    public string $email = '';
    public string $role = '';
    public string $status = '';
    public string $password = '';

    public static function fromRow(array $row): self
    {
        $u = new self();
        $u->id       = (int)($row['userID'] ?? 0);
        $u->name     = (string)($row['name']   ?? '');
        $u->email    = (string)($row['email']  ?? '');
        $u->role     = (string)($row['role']   ?? '');
        $u->status   = (string)($row['status'] ?? '');
        $u->password = (string)($row['password'] ?? '');
        return $u;
    }

    /** list all users */
    public static function fetchAll(\mysqli $conn): array
    {
        $sql = "SELECT userID, name, email, role, status
                  FROM users
              ORDER BY userID ASC";
        $res = $conn->query($sql);
        if ($res === false) return [];
        $out = [];
        while ($row = $res->fetch_assoc()) $out[] = self::fromRow($row);
        $res->free();
        return $out;
    }

    /** load a single user (for the edit form) */
    public static function findById(\mysqli $conn, int $id): ?self
    {
        $sql = "SELECT userID, name, email, role, status, password FROM users WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row ? self::fromRow($row) : null;
    }

    /** roles dropdown from profiles (auto-updates when profiles change) */
    public static function fetchRoles(\mysqli $conn): array
    {
        $roles = [];
        $res = $conn->query("SELECT role FROM profiles ORDER BY role ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) $roles[] = $row['role'];
            $res->free();
        }
        return $roles;
    }

    /** uniqueness check for email on update exludes current users */
    public static function emailExistsForOther(\mysqli $conn, string $email, int $excludeId): bool
    {
        $sql = "SELECT COUNT(*) AS c FROM users WHERE email = ? AND userID <> ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $email, $excludeId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return ((int)$row['c']) > 0;
    }

    /**
     * updates editable fields . :>
     * $newPassword: pass as null or '' to keep the existing password. :>
     */
    public static function update(
        \mysqli $conn,
        int $id,
        string $name,
        string $email,
        string $role,
        ?string $newPassword = null
    ): bool {
        if ($newPassword === null || $newPassword === '') {
            $sql = "UPDATE users SET name = ?, email = ?, role = ? WHERE userID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssi', $name, $email, $role, $id);
        } else {
            $sql = "UPDATE users SET name = ?, email = ?, role = ?, password = ? WHERE userID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssi', $name, $email, $role, $newPassword, $id);
        }
        return $stmt->execute();
    }
}
