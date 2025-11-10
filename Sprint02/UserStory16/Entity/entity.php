<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Delete a request by its ID
    public function deleteByID($requestID) {
        try {
            // First check if the request exists
            $check = $this->conn->prepare("SELECT * FROM requests WHERE request_id = :id");
            $check->bindParam(':id', $requestID, PDO::PARAM_INT);
            $check->execute();

            if ($check->rowCount() == 0) {
                return ['success' => false, 'message' => "Request not found."];
            }

            // Proceed to delete
            $stmt = $this->conn->prepare("DELETE FROM requests WHERE request_id = :id");
            $stmt->bindParam(':id', $requestID, PDO::PARAM_INT);
            $stmt->execute();

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
?>
