<?php
require_once __DIR__ . '/database.php';

class Report
{
    // Count all requests for a given date
    public static function countRequestsByDate(string $date): int
    {
        $db = getDBConnection();
        $sql = "SELECT COUNT(*) AS total FROM requests WHERE DATE(created_at) = ?";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $db->error);
            return 0;
        }

        $stmt->bind_param('s', $date);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int) $total;
    }

    // Count confirmed requests for a given date
    public static function countConfirmedByDate(string $date): int
    {
        $db = getDBConnection();
        $sql = "SELECT COUNT(*) AS total 
                FROM requests 
                WHERE DATE(created_at) = ? AND status = 'confirmed'";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $db->error);
            return 0;
        }

        $stmt->bind_param('s', $date);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int) $total;
    }
}
?>
