<?php
require_once __DIR__ . '/../database.php';

class Request {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Find requests that match given filters
    public function findByFilters($filters) {
        $conditions = [];
        $params = [];

        $sql = "SELECT r.request_id, r.title, r.description, r.location, r.preferred_date, r.status,
                       c.category_name
                FROM requests r
                JOIN service_categories c ON r.category_id = c.category_id
                WHERE 1=1";

        if (!empty($filters['keyword'])) {
            $sql .= " AND (r.title LIKE :keyword OR r.description LIKE :keyword)";
            $params[':keyword'] = "%" . $filters['keyword'] . "%";
        }

        if (!empty($filters['category'])) {
            $sql .= " AND r.category_id = :category";
            $params[':category'] = $filters['category'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND r.status = :status";
            $params[':status'] = $filters['status'];
        }

        if (!empty($filters['location'])) {
            $sql .= " AND r.location LIKE :location";
            $params[':location'] = "%" . $filters['location'] . "%";
        }

        if (!empty($filters['date'])) {
            $sql .= " AND r.preferred_date = :date";
            $params[':date'] = $filters['date'];
        }

        $sql .= " ORDER BY r.created_at DESC";

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
