<?php
require_once __DIR__ . '/../database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Search categories by filters
    public function findByFilters($filters) {
        $keyword = $filters['keyword'] ?? '';

        try {
            $sql = "SELECT * FROM service_categories 
                    WHERE category_name LIKE :keyword 
                       OR description LIKE :keyword 
                    ORDER BY created_at DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database Error: " . $e->getMessage() . "</p>";
            return [];
        }
    }
}
?>
