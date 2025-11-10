<?php
require_once __DIR__ . '/database.php';

class Report
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
        if (!$this->conn) {
            throw new RuntimeException("Database connection failed.");
        }
    }

    // Count all requests between two dates
    public function countRequestsBetween(string $startDate, string $endDate): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM requests
                WHERE DATE(created_at) BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int)$total;
    }

    // Count confirmed requests between two dates
    public function countConfirmedBetween(string $startDate, string $endDate): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM requests
                WHERE status = 'confirmed'
                  AND DATE(created_at) BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int)$total;
    }

    // Optional: count requests by any status between two dates
    public function countByStatusBetween(string $status, string $startDate, string $endDate): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM requests
                WHERE status = ?
                  AND DATE(created_at) BETWEEN ? AND ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param("sss", $status, $startDate, $endDate);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int)$total;
    }
}
?>
