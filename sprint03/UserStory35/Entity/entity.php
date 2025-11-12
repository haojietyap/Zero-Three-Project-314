<?php
require_once __DIR__ . '/../database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get category by ID
    public function getCategoryByID($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM service_categories WHERE category_id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database Error: " . $e->getMessage() . "</p>";
            return null;
        }
    }

    // Update category details
    public function update($categoryID, $data) {
        $errors = [];

        // Validation
        if (empty($data['category_name'])) {
            $errors[] = "Category name cannot be empty.";
        }

        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        try {
            $stmt = $this->conn->prepare("
                UPDATE service_categories
                SET category_name = :name,
                    description = :description,
                    updated_at = NOW()
                WHERE category_id = :id
            ");
            $stmt->execute([
                ':name' => $data['category_name'],
                ':description' => $data['description'],
                ':id' => $categoryID
            ]);

            if ($stmt->rowCount() > 0) {
                return ['category_id' => $categoryID];
            } else {
                return ['errors' => ['No changes detected or invalid category ID.']];
            }
        } catch (PDOException $e) {
            return ['errors' => ["Database error: " . $e->getMessage()]];
        }
    }
}
?>
