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

    public static function emailExists(string $email): bool
    {
        $st = self::pdo()->prepare('SELECT 1 FROM user_accounts WHERE email = ? LIMIT 1');
        $st->execute([trim($email)]);
        return (bool)$st->fetchColumn();
    }

    public static function createAccount(array $d): int
    {
        $sql = 'INSERT INTO user_accounts (full_name, email, password, phone_number, address, user_profiles, user_account_status)
                VALUES (:full_name, :email, :password, :phone_number, :address, "Unassigned", "ACTIVE")';
        $st = self::pdo()->prepare($sql);
        $st->execute([
            ':full_name'    => $d['full_name'],
            ':email'        => $d['email'],
            ':password'     => $d['password'],
            ':phone_number' => $d['phone_number'] ?: null,
            ':address'      => $d['address'] ?: null,
        ]);
        return (int)self::pdo()->lastInsertId();
    }
}
