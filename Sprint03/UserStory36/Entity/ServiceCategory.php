<?php
require_once __DIR__ . '/../Utilities/DB.php';

class Category
{
    private int $id;
    private string $name;
    private string $description;

    public function __construct(int $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public static function findById(int $categoryID): ?Category
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$categoryID]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Category(
            (int)$row['id'],
            $row['name'],
            $row['description']
        );
    }

    public function deleteById(int $categoryID): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$categoryID]);
    }
}
?>

