<?php
require_once __DIR__ . '/../database.php';

class Category {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Delete a category by ID
    public function deleteByID($categoryID) {
        try {
            // Ensure category exists
            $check = $this->conn->prepare("SELECT * FROM service_categories WHERE category_id = :id");
            $check->execute([':id' => $categoryID]);
            if ($check->rowCount() == 0) {
                return false;
            }

            // Proceed to delete
            $stmt = $this->conn->prepare("DELETE FROM service_categories WHERE category_id = :id");
            $stmt->execute([':id' => $categoryID]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database Error: " . $e->getMessage() . "</p>";
            return false;
        }
    }
}
?>
