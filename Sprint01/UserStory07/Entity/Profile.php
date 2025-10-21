<?php

declare(strict_types=1);

class Profile
{
    public int $id = 0;
    public string $role = '';
    public string $permissions = '';
    public string $description = '';

    public static function fromRow(array $row): self
    {
        $p = new self();
        $p->id          = (int)($row['profileID']   ?? 0);
        $p->role        = (string)($row['role']     ?? '');
        $p->permissions = (string)($row['permissions'] ?? '');
        $p->description = (string)($row['description'] ?? '');
        return $p;
    }

    /** this lists all profiles. */
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

    /** this will load a single profile by ID . */
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
}
