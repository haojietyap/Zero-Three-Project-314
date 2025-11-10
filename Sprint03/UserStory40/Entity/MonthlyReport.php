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

    // Count all requests in a specific month
    public function countRequestsInMonth(int $year, int $month): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM requests
                WHERE YEAR(created_at) = ? AND MONTH(created_at) = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param("ii", $year, $month);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int)$total;
    }

    // Count confirmed requests in a specific month
    public function countConfirmedInMonth(int $year, int $month): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM requests
                WHERE status = 'confirmed'
                  AND YEAR(created_at) = ? AND MONTH(created_at) = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param("ii", $year, $month);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int)$total;
    }

    // Optional: Generic method to count requests by status in a month
    public function countByStatusInMonth(string $status, int $year, int $month): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM requests
                WHERE status = ?
                  AND YEAR(created_at) = ? AND MONTH(created_at) = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return 0;
        }

        $stmt->bind_param("sii", $status, $year, $month);
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        $stmt->close();

        return (int)$total;
    }
}
?>
