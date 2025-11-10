<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Search requests by keyword for a specific PIN user
    public function searchByUser($userID, $criteria) {
        $keyword = "%" . $criteria['keyword'] . "%";

        try {
            $sql = "SELECT r.request_id, r.title, r.description, r.location, 
                           r.preferred_date, r.status, c.category_name
                    FROM requests r
                    JOIN service_categories c ON r.category_id = c.category_id
                    WHERE r.pin_user_id = :userID
                      AND (r.title LIKE :keyword OR r.description LIKE :keyword OR r.location LIKE :keyword)
                    ORDER BY r.created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return [];
        }
    }
}
?>
