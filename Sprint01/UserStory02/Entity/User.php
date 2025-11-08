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

    public static function all(): array
    {
        $sql = "SELECT userid, full_name, email, password, phone_number, address, user_profiles, user_account_status, created_at
                FROM user_accounts
                ORDER BY userid ASC";
        $st = self::pdo()->query($sql);
        return $st->fetchAll() ?: [];
    }
}
