<?php
require_once __DIR__ . '/../database.php';

class Report {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Count all requests for the given month and year
    public function countRequestsInMonth($year, $month) {
        try {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS total
                FROM requests
                WHERE YEAR(created_at) = :year
                  AND MONTH(created_at) = :month
            ");
            $stmt->execute([':year' => $year, ':month' => $month]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return 0;
        }
    }

    // Count confirmed requests for the given month and year
    public function countConfirmedInMonth($year, $month) {
        try {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) AS total
                FROM requests
                WHERE YEAR(created_at) = :year
                  AND MONTH(created_at) = :month
                  AND status = 'confirmed'
            ");
            $stmt->execute([':year' => $year, ':month' => $month]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return 0;
        }
    }
}
?>
