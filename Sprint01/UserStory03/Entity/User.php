<?php
declare(strict_types=1);

final class User
{
    private static ?\PDO $db = null;

    private static function pdo(): \PDO
    {
        if (self::$db instanceof \PDO) return self::$db;
        $dsn = "mysql:host=127.0.0.1;dbname=zerothree;charset=utf8mb4";
        self::$db = new \PDO($dsn, 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return self::$db;
    }

    public static function existsById(int $userid): bool
    {
        $st = self::pdo()->prepare('SELECT 1 FROM user_accounts WHERE userid = ? LIMIT 1');
        $st->execute([$userid]);
        return (bool)$st->fetchColumn();
    }

    public static function findById(int $userid): ?array
    {
        $st = self::pdo()->prepare('SELECT userid, full_name, email, password, phone_number, address, user_profiles, user_account_status, created_at, updated_at FROM user_accounts WHERE userid = ?');
        $st->execute([$userid]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public static function all(): array
    {
        $sql = "SELECT userid, full_name, email, password, phone_number, address, user_profiles, user_account_status, created_at, updated_at
                FROM user_accounts
                ORDER BY userid ASC";
        $st = self::pdo()->query($sql);
        return $st->fetchAll() ?: [];
    }

    public static function emailUniqueForUpdate(int $userid, string $email): bool
    {
        $st = self::pdo()->prepare('SELECT COUNT(*) FROM user_accounts WHERE email = ? AND userid <> ?');
        $st->execute([trim($email), $userid]);
        return ((int)$st->fetchColumn()) === 0;
    }

    public static function updateBasic(int $userid, array $d): void
    {
        $sql = 'UPDATE user_accounts
                   SET full_name = :full_name,
                       email = :email,
                       password = :password,
                       phone_number = :phone_number,
                       address = :address
                 WHERE userid = :userid';
        $st = self::pdo()->prepare($sql);
        $st->execute([
            ':full_name'    => $d['full_name'],
            ':email'        => $d['email'],
            ':password'     => $d['password'],
            ':phone_number' => $d['phone_number'] ?: null,
            ':address'      => $d['address'] ?: null,
            ':userid'       => $userid,
        ]);
    }
}
