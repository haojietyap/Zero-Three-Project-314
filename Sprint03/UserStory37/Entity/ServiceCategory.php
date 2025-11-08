<?php
require_once __DIR__ . '/../Utilities/DB.php';

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
    public function getStatus(): string { return $this->status; }

    // Search categories based on filters
    public static function findByFilters(array $filters): array
    {
        $db = Database::getConnection();
        $keyword = '%' . ($filters['keyword'] ?? '') . '%';
        $status = $filters['status'] ?? 'active';

        $stmt = $db->prepare(
            "SELECT * FROM categories 
             WHERE (name LIKE :keyword OR description LIKE :keyword) 
             AND status = :status"
        );

        $stmt->execute([
            'keyword' => $keyword,
            'status'  => $status
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        foreach ($rows as $row) {
            $categories[] = new Category(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['status']
            );
        }

        return $categories;
    }
}
