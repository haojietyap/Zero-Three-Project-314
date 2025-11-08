<?php
class report {
    private mysqli $conn;

    public function __construct() {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db   = 'zerothree';

        $this->conn = new mysqli($host, $user, $pass, $db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function countRequestsBetween(string $startDate, string $endDate): int {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM requests 
            WHERE DATE(created_at) BETWEEN ? AND ?
        ");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (int)$result['total'];
    }

    public function countConfirmedBetween(string $startDate, string $endDate): int {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as total 
            FROM requests 
            WHERE status = 'confirmed' 
            AND DATE(created_at) BETWEEN ? AND ?
        ");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return (int)$result['total'];
    }
}
?>
