<?php
class report {
    private mysqli $conn;

    public function __construct() {
        // Update these with your database credentials
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db   = 'your_database_name';

        $this->conn = new mysqli($host, $user, $pass, $db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // ===== Monthly report methods =====
    public function countRequestsInMonth(int $year, int $month): int {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM requests 
            WHERE YEAR(created_at) = ? AND MONTH(created_at) = ?
        ");
        $stmt->bind_param("ii", $year, $month);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (int)$result['total'];
    }

    public function countConfirmedInMonth(int $year, int $month): int {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM requests 
            WHERE status = 'confirmed' 
            AND YEAR(created_at) = ? AND MONTH(created_at) = ?
        ");
        $stmt->bind_param("ii", $year, $month);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (int)$result['total'];
    }
}
?>
