<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Retrieve all requests by PIN user ID
    public function findByUserID($userID) {
        try {
            $sql = "SELECT r.request_id, r.title, r.description, r.location, 
                           r.preferred_date, r.status, c.category_name
                    FROM requests r
                    JOIN service_categories c ON r.category_id = c.category_id
                    WHERE r.pin_user_id = :userID
                    ORDER BY r.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?>
