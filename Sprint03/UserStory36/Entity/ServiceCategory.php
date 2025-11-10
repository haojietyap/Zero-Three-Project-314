<?php
require_once __DIR__ . '/database.php';

class Category
{
    private int $id;
    private string $name;
    private string $description;
    private bool $isActive;

    public function __construct(int $id, string $name, string $description, bool $isActive)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->isActive = $isActive;
    }

    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function isActive(): bool { return $this->isActive; }

    // Find category by ID
    public static function findById(int $categoryID): ?Category
    {
        $db = getDBConnection();
        $sql = "SELECT category_id, category_name, description, is_active
                FROM service_categories
                WHERE category_id = ? LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $categoryID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row) return null;

        return new Category(
            (int)$row['category_id'],
            $row['category_name'],
            $row['description'],
            (bool)$row['is_active']
        );
    }

    // Delete category by ID
    public static function deleteById(int $categoryID): bool
    {
        $db = getDBConnection();
        $sql = "DELETE FROM service_categories WHERE category_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $categoryID);
        return $stmt->execute();
    }
}
?>
