<?php
require_once __DIR__ . '/../database.php';

class Report {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Count all requests for a specific date
    public function countRequestsByDate($date) {
        try {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS total
                FROM requests
                WHERE DATE(created_at) = :report_date
            ");
            $stmt->execute([':report_date' => $date]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return 0;
        }
    }

    // Count confirmed requests for a specific date
    public function countConfirmedByDate($date) {
        try {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS total
                FROM requests
                WHERE DATE(created_at) = :report_date
                  AND status = 'confirmed'
            ");
            $stmt->execute([':report_date' => $date]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return 0;
        }
    }
}
?>
