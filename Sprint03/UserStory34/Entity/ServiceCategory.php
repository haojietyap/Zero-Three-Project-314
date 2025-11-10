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

    /**
     * Fetch all service categories.
     * Matches the actual columns from your database.
     */
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
        if (!$stmt) {
            throw new RuntimeException("SQL prepare failed: " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            // Convert is_active (1/0) to readable text, if you want
            $row['status'] = $row['is_active'] ? 'Active' : 'Inactive';
            unset($row['is_active']);
            $categories[] = $row;
        }

        $stmt->close();
        return $categories;
    }
}
?>
