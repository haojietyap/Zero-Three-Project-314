<?php
require_once __DIR__ . '/database.php';

class ServiceCategory
{
    private $conn;

    public function __construct()
    {
        $this->conn = getDBConnection();
        if (!$this->conn) {
            throw new RuntimeException("Database connection failed.");
        }
    }

    // List all categories
    public function listAllCategories(): array
    {
        $sql = "SELECT 
                    category_id AS id, 
                    category_name AS name, 
                    description, 
                    is_active, 
                    created_at, 
                    updated_at
                FROM service_categories
                ORDER BY category_id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $row['status'] = $row['is_active'] ? 'Active' : 'Inactive';
            unset($row['is_active']);
            $categories[] = $row;
        }

        $stmt->close();
        return $categories;
    }

    // Search categories by keyword in name or description
    public function searchCategories(string $keyword): array
    {
        $keyword = "%$keyword%";
        $sql = "SELECT 
                    category_id AS id, 
                    category_name AS name, 
                    description, 
                    is_active, 
                    created_at, 
                    updated_at
                FROM service_categories
                WHERE (category_name LIKE ? OR description LIKE ?)
                ORDER BY category_id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $row['status'] = $row['is_active'] ? 'Active' : 'Inactive';
            unset($row['is_active']);
            $categories[] = $row;
        }

        $stmt->close();
        return $categories;
    }
}
?>
