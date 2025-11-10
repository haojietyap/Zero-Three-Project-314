<?php
require_once __DIR__ . '/database.php';

class Category
{
    private int $id;
    private string $name;
    private string $description;
    private string $status;

    public function __construct(int $id, string $name, string $description, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function isActive(): bool { return $this->status === 'active'; }

    // Search categories by filters
    public static function findByFilters(array $filters): array
    {
        $db = getDBConnection();
        $keyword = '%' . ($filters['keyword'] ?? '') . '%';
        $status  = $filters['status'] ?? 'active';

        $sql = "SELECT category_id, name, description, status 
                FROM service_categories 
                WHERE (name LIKE ? OR description LIKE ?) 
                  AND status = ? 
                ORDER BY category_id ASC";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('sss', $keyword, $keyword, $status);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = new Category(
                (int)$row['category_id'],
                $row['name'],
                $row['description'],
                $row['status']
            );
        }

        $stmt->close();
        return $categories;
    }
}
?>
