<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Search completed matches by user and filters
    public function searchCompletedByUser($userID, $filters) {
        $keyword = "%" . ($filters['keyword'] ?? '') . "%";
        $date = $filters['date'] ?? null;

        try {
            $sql = "SELECT m.match_id, r.title, m.service_date, m.status, m.completed_at
                    FROM matches m
                    JOIN requests r ON m.request_id = r.request_id
                    WHERE m.pin_user_id = :userID
                      AND m.status = 'COMPLETED'";

            if (!empty($filters['keyword'])) {
                $sql .= " AND (r.title LIKE :keyword OR r.description LIKE :keyword)";
            }
            if (!empty($filters['date'])) {
                $sql .= " AND DATE(m.completed_at) = :date";
            }

            $sql .= " ORDER BY m.completed_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            if (!empty($filters['keyword'])) $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            if (!empty($filters['date'])) $stmt->bindParam(':date', $date, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return [];
        }
    }
}
?>
