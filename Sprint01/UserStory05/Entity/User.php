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

    /** this will lists all users */
    public static function fetchAll(\mysqli $conn): array
    {
        $sql = "SELECT userID, name, email, role, status FROM users ORDER BY userID ASC";
        $res = $conn->query($sql);
        if ($res === false) return [];
        $users = [];
        while ($row = $res->fetch_assoc()) $users[] = self::fromRow($row);
        $res->free();
        return $users;
    }

    /** this finds a single user by ID */
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

    /** this fetches available roles */
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

    /** email uniqueness check (exclude current user) */
    public static function emailExistsForOther(\mysqli $conn, string $email, int $excludeId): bool
    {
        $sql = "SELECT COUNT(*) AS c FROM users WHERE email = ? AND userID <> ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $email, $excludeId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return ((int)$row['c']) > 0;
    }

    /** this updates editable fields (status excluded) */
    public static function update(\mysqli $conn, int $id, string $name, string $email, string $role, ?string $newPassword = null): bool
    {
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

    /** this activates/suspends a user */
    public static function setStatus(\mysqli $conn, int $id, string $newStatus): bool
    {
        if (!in_array($newStatus, ['Active', 'Inactive'], true)) return false;
        $sql = "UPDATE users SET status = ? WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $newStatus, $id);
        return $stmt->execute();
    }

    /** function will search users by name or email */
    public static function search(\mysqli $conn, string $query): array
    {
        $like = '%' . $query . '%';
        $sql = "SELECT userID, name, email, role, status
                  FROM users
                 WHERE name LIKE ? OR email LIKE ?
              ORDER BY userID ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $like, $like);
        $stmt->execute();
        $res = $stmt->get_result();
        $out = [];
        while ($row = $res->fetch_assoc()) $out[] = self::fromRow($row);
        return $out;
    }
}
