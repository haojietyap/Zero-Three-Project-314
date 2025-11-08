<?php
declare(strict_types=1);

/**
 * Entity: User — matched to provided DB schema.
 * Table: user_accounts
 * Columns used: userid, full_name, email, password, phone_number, address,
 *               user_profiles (ROLE), user_account_status (STATUS), updated_at (UPDATED)
 */
final class User
{
    private static ?\PDO $pdo = null;

    // Update credentials if your MySQL differs
    private static string $DB_HOST = '127.0.0.1';
    private static string $DB_PORT = '3306';
    private static string $DB_NAME = 'zerothree';
    private static string $DB_USER = 'root';
    private static string $DB_PASS = '';

    private static function dsn(): string {
        return 'mysql:host=' . self::$DB_HOST . ';port=' . self::$DB_PORT . ';dbname=' . self::$DB_NAME . ';charset=utf8mb4';
    }

    private static function pdo(): \PDO {
        if (!self::$pdo) {
            self::$pdo = new \PDO(self::dsn(), self::$DB_USER, self::$DB_PASS, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$pdo;
    }

    /** List all users for table */
    public static function all(): array
    {
        $sql = "
            SELECT
                userid,
                full_name,
                email,
                password,
                phone_number,
                address,
                user_profiles        AS role,
                user_account_status  AS status,
                updated_at           AS updated
            FROM user_accounts
            ORDER BY full_name ASC
        ";
        return self::pdo()->query($sql)->fetchAll();
    }

    /** Get single user for edit */
    public static function getById(int $userid): ?array
    {
        $st = self::pdo()->prepare("
            SELECT
                userid, full_name, email, password,
                phone_number, address,
                user_profiles AS role,
                user_account_status AS status,
                updated_at AS updated
            FROM user_accounts
            WHERE userid = :id
            LIMIT 1
        ");
        $st->execute([':id' => $userid]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public static function existsById(int $userid): bool
    {
        $st = self::pdo()->prepare('SELECT 1 FROM user_accounts WHERE userid = :id');
        $st->execute([':id' => $userid]);
        return (bool)$st->fetchColumn();
    }

    /** Update basic profile fields (not password, not role/status here) */
    public static function updateUser(array $d): bool
{
    $hasPwd = isset($d['password']) && trim((string)$d['password']) !== '';
    if ($hasPwd) {
        $st = self::pdo()->prepare("
            UPDATE user_accounts
               SET full_name = :full_name,
                   email = :email,
                   phone_number = :phone_number,
                   address = :address,
                   password = :password
             WHERE userid = :userid
        ");
    } else {
        $st = self::pdo()->prepare("
            UPDATE user_accounts
               SET full_name = :full_name,
                   email = :email,
                   phone_number = :phone_number,
                   address = :address
             WHERE userid = :userid
        ");
    }
    $params = [
        ':full_name'    => (string)($d['full_name'] ?? ''),
        ':email'        => (string)($d['email'] ?? ''),
        ':phone_number' => (string)($d['phone_number'] ?? ''),
        ':address'      => (string)($d['address'] ?? ''),
        ':userid'       => (int)($d['userid'] ?? 0),
    ];
    if ($hasPwd) {
        // If you want to hash: $params[':password'] = password_hash((string)$d['password'], PASSWORD_DEFAULT);
        $params[':password'] = (string)$d['password']; // storing as-is to match your current schema
    }
    return $st->execute($params);
}

    /** Activate/Suspend — status values are uppercase per schema */
    public static function updateStatus(int $userid, string $status): void
    {
        $status = (strtoupper($status) === 'ACTIVE') ? 'ACTIVE' : 'SUSPENDED';
        $st = self::pdo()->prepare('UPDATE user_accounts SET user_account_status = :s WHERE userid = :id');
        $st->execute([':s' => $status, ':id' => $userid]);
    }

    /** Search by name/email (LIKE), or exact userid */
    public static function search(string $q): array
    {
        $q = trim($q);
        if ($q === '') return [];
        $like = "%{$q}%";
        $idExact = ctype_digit($q) ? (int)$q : -1;

        $sql = "
            SELECT
                userid, full_name, email, password,
                phone_number, address,
                user_profiles AS role,
                user_account_status AS status,
                updated_at AS updated
            FROM user_accounts
            WHERE full_name LIKE :like1 OR email LIKE :like2 OR userid = :idExact
            ORDER BY full_name ASC
            LIMIT 50
        ";
        $st = self::pdo()->prepare($sql);
        $st->bindValue(':like1', $like, \PDO::PARAM_STR);
        $st->bindValue(':like2', $like, \PDO::PARAM_STR);
        $st->bindValue(':idExact', $idExact, \PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }
}
