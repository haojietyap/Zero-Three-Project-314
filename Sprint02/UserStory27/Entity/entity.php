<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get the view count for a specific request
    public function getViewCount($requestID) {
        try {
            $sql = "SELECT view_count FROM requests WHERE request_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $requestID, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return intval($result['view_count']);
            } else {
                return null; // not found
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return null;
        }
    }
}
?>
