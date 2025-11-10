<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Fetch one request by ID
    public function getRequestById($requestID) {
        $sql = "SELECT * FROM requests WHERE request_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $requestID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update existing request
    public function update($requestID, $data) {
        $errors = [];

        if (empty($data['title'])) $errors[] = "Title is required.";
        if (empty($data['description'])) $errors[] = "Description is required.";
        if (empty($data['location'])) $errors[] = "Location is required.";
        if (empty($data['preferred_date'])) $errors[] = "Preferred date is required.";

        if (!empty($errors)) return ['errors' => $errors, 'old' => $data];

        try {
            $sql = "UPDATE requests
                    SET title = :title,
                        description = :description,
                        location = :location,
                        preferred_date = :preferred_date,
                        updated_at = NOW()
                    WHERE request_id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':title' => $data['title'],
                ':description' => $data['description'],
                ':location' => $data['location'],
                ':preferred_date' => $data['preferred_date'],
                ':id' => $requestID
            ]);

            return ['request_id' => $requestID];
        } catch (PDOException $e) {
            return ['errors' => ['Database error: ' . $e->getMessage()]];
        }
    }
}
?>
