<?php
require_once __DIR__ . '/../database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Retrieve all categories
    public function listAllCategories() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM service_categories ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database Error: " . $e->getMessage() . "</p>";
            return [];
        }
    }
}
?>
