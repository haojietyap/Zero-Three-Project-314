<?php
require_once __DIR__ . '/../database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function createCategory($data) {
        $errors = [];

        // Validation
        if (empty($data['category_name'])) {
            $errors[] = "Category name is required.";
        }

        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        try {
            // Check for duplicate category
            $check = $this->conn->prepare("SELECT * FROM service_categories WHERE category_name = :name");
            $check->execute([':name' => $data['category_name']]);
            if ($check->rowCount() > 0) {
                return ['errors' => ["Category name already exists."]];
            }

            // Insert new category
            $stmt = $this->conn->prepare("
                INSERT INTO service_categories (category_name, description, created_at)
                VALUES (:name, :description, NOW())
            ");
            $stmt->execute([
                ':name' => $data['category_name'],
                ':description' => $data['description']
            ]);

            $categoryID = $this->conn->lastInsertId();
            return ['category_id' => $categoryID];

        } catch (PDOException $e) {
            return ['errors' => ["Database error: " . $e->getMessage()]];
        }
    }
}
?>
