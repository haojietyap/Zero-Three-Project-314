<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Retrieve all requests or filtered requests
    public function findByFilters($filters = []) {
        $sql = "SELECT r.request_id, r.title, r.description, r.location, 
                       r.preferred_date, r.status, c.category_name
                FROM requests r
                JOIN service_categories c ON r.category_id = c.category_id
                ORDER BY r.created_at DESC";

        $params = [];
        $conditions = [];

        // Apply filters dynamically
        if (!empty($filters['keyword'])) {
            $conditions[] = "(r.title LIKE :keyword OR r.description LIKE :keyword)";
            $params[':keyword'] = "%" . $filters['keyword'] . "%";
        }

        if (!empty($filters['status'])) {
            $conditions[] = "r.status = :status";
            $params[':status'] = $filters['status'];
        }

        if (!empty($conditions)) {
            $sql = str_replace("ORDER BY", "WHERE " . implode(" AND ", $conditions) . " ORDER BY", $sql);
        }

        try {
            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return [];
        }
    }
}
?>
