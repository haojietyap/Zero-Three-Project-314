<?php
require_once __DIR__ . '/../Utilities/DB.php';

class Report
{
    public static function countRequestsByDate(string $date): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM requests WHERE DATE(created_at) = :date");
        $stmt->execute(['date' => $date]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['total'] ?? 0);
    }

    public static function countConfirmedByDate(string $date): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM requests WHERE DATE(created_at) = :date AND status = 'confirmed'");
        $stmt->execute(['date' => $date]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['total'] ?? 0);
    }
}
?>