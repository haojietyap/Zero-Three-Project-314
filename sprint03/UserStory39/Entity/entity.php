<?php
require_once __DIR__ . '/../database.php';

class Report {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Count all requests within a given date range
    public function countRequestsBetween($startDate, $endDate) {
        try {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS total
                FROM requests
                WHERE DATE(created_at) BETWEEN :start_date AND :end_date
            ");
            $stmt->execute([
                ':start_date' => $startDate,
                ':end_date' => $endDate
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return 0;
        }
    }

    // Count confirmed requests within a given date range
    public function countConfirmedBetween($startDate, $endDate) {
        try {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS total
                FROM requests
                WHERE DATE(created_at) BETWEEN :start_date AND :end_date
                  AND status = 'confirmed'
            ");
            $stmt->execute([
                ':start_date' => $startDate,
                ':end_date' => $endDate
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return 0;
        }
    }
}
?>
