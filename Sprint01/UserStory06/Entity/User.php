<?php
declare(strict_types=1);

final class User
{
    private static ?\PDO $pdo = null;
    private static string $DB_HOST='127.0.0.1';
    private static string $DB_PORT='3306';
    private static string $DB_NAME='zerothree';
    private static string $DB_USER='root';
    private static string $DB_PASS='';

    private static function dsn(): string {
        return 'mysql:host='.self::$DB_HOST.';port='.self::$DB_PORT.';dbname='.self::$DB_NAME.';charset=utf8mb4';
    }
    private static function pdo(): \PDO {
        if (!self::$pdo) {
            self::$pdo = new \PDO(self::dsn(), self::$DB_USER, self::$DB_PASS, [
                \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES=>false,
            ]);
        }
        return self::$pdo;
    }

    public static function all(): array {
        $sql = "SELECT userid, full_name, email, password, phone_number, address,
                       user_profiles AS role, user_account_status AS status, updated_at AS updated
                FROM user_accounts ORDER BY full_name ASC";
        return self::pdo()->query($sql)->fetchAll();
    }

    public static function unassigned(): array {
        $sql = "SELECT userid, full_name, email, password, phone_number, address,
                       user_profiles AS role, user_account_status AS status, updated_at AS updated
                FROM user_accounts
                WHERE user_profiles IS NULL OR user_profiles = '' OR user_profiles = 'Unassigned'
                ORDER BY full_name ASC";
        return self::pdo()->query($sql)->fetchAll();
    }

    public static function getById(int $userid): ?array {
        $st = self::pdo()->prepare("SELECT userid, full_name, email, password, phone_number, address,
                                           user_profiles AS role, user_account_status AS status, updated_at AS updated
                                    FROM user_accounts WHERE userid = :id LIMIT 1");
        $st->execute([':id'=>$userid]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public static function updateRole(int $userid, string $role): bool {
        $st = self::pdo()->prepare("UPDATE user_accounts SET user_profiles = :r WHERE userid = :id");
        return $st->execute([':r'=>$role, ':id'=>$userid]);
    }

    public static function existsById(int $userid): bool {
        $st = self::pdo()->prepare("SELECT 1 FROM user_accounts WHERE userid = :id");
        $st->execute([':id'=>$userid]);
        return (bool)$st->fetchColumn();
    }
}
