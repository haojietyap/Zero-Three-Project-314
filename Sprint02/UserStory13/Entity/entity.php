<?php
require_once __DIR__ . '/../database.php';


class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createRequest($userID, $data) {
        $errors = [];

        // Validation
        if (empty($data['title'])) $errors[] = "Title is required.";
        if (empty($data['description'])) $errors[] = "Description is required.";
        if (empty($data['category_id'])) $errors[] = "Category ID is required.";
        if (!empty($errors)) return ['errors' => $errors];

        // Insert request
        try {
            $sql = "INSERT INTO requests 
                    (pin_user_id, category_id, title, description, location, preferred_date, status)
                    VALUES (:pin_user_id, :category_id, :title, :description, :location, :preferred_date, 'OPEN')";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':pin_user_id' => $userID,
                ':category_id' => $data['category_id'],
                ':title' => $data['title'],
                ':description' => $data['description'],
                ':location' => $data['location'],
                ':preferred_date' => $data['preferred_date']
            ]);

            return ['request_id' => $this->conn->lastInsertId()];
        } catch (PDOException $e) {
            return ['errors' => ['Database error: ' . $e->getMessage()]];
        }
    }
}
?>
