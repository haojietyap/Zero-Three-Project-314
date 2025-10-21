<?php

declare(strict_types=1);

class Profile
{
    public int $id = 0;
    public string $role = '';
    public string $permissions = '';
    public string $description = '';

    // this keeps in sync with ENUM in db_connect.php
    private static array $allowedRoles = ['User Admin', 'CSR Rep', 'PIN', 'Platform Manager'];

    public static function allowedRoles(): array
    {
        return self::$allowedRoles;
    }

    public static function fromRow(array $row): self
    {
        $p = new self();
        $p->id          = (int)($row['profileID']   ?? 0);
        $p->role        = (string)($row['role']     ?? '');
        $p->permissions = (string)($row['permissions'] ?? '');
        $p->description = (string)($row['description'] ?? '');
        return $p;
    }

    /** this lists all profiles */
    public static function fetchAll(\mysqli $conn): array
    {
        $sql = "SELECT profileID, role, permissions, description
                  FROM profiles
              ORDER BY role ASC";
        $res = $conn->query($sql);
        if ($res === false) return [];
        $out = [];
        while ($row = $res->fetch_assoc()) {
            $out[] = self::fromRow($row);
        }
        $res->free();
        return $out;
    }

    /** this loads a single profile by ID so it can be edited. */
    public static function findById(\mysqli $conn, int $id): ?self
    {
        $sql = "SELECT profileID, role, permissions, description
                  FROM profiles
                 WHERE profileID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row ? self::fromRow($row) : null;
    }

    /** checks if there a different row already using this role (uniqueness guard on update) */
    public static function existsByRoleForOther(\mysqli $conn, string $role, int $excludeId): bool
    {
        $sql = "SELECT COUNT(*) AS c FROM profiles WHERE role = ? AND profileID <> ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $role, $excludeId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return ((int)$row['c']) > 0;
    }

    /** this updates the role, permissions, description. */
    public static function update(
        \mysqli $conn,
        int $id,
        string $role,
        string $permissions,
        string $description
    ): bool {
        $sql = "UPDATE profiles
                   SET role = ?, permissions = ?, description = ?
                 WHERE profileID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $role, $permissions, $description, $id);
        return $stmt->execute();
    }
}
