<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Retrieve the shortlist count for a specific request
    public function getShortlistCount($requestID) {
        try {
            $sql = "SELECT shortlist_count FROM requests WHERE request_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $requestID, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return intval($result['shortlist_count']);
            } else {
                return null; // Not found
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return null;
        }
    }
}
?>
