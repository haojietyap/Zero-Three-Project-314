<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get all completed matches by a specific PIN user
    public function findCompletedByUser($userID) {
        try {
            $sql = "SELECT m.match_id, r.title, m.service_date, m.status, m.completed_at
                    FROM matches m
                    JOIN requests r ON m.request_id = r.request_id
                    WHERE m.pin_user_id = :userID AND m.status = 'COMPLETED'
                    ORDER BY m.completed_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return [];
        }
    }
}
?>
