<?php
require_once __DIR__ . '/../Utilities/DB.php';

class Category
{
    private int $id;
    private string $name;
    private string $description;
    private DateTimeImmutable $updatedAt;

    public function __construct(int $id, string $name, string $description, DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->updatedAt = $updatedAt;
    }

    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }

    public function applyUpdates(array $data): void
    {
        $this->name = trim($data['name'] ?? $this->name);
        $this->description = trim($data['description'] ?? $this->description);
        $this->updatedAt = new DateTimeImmutable('now');
    }

    public function validateUpdate(): array
    {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = 'Category name cannot be empty.';
        }

        if (strlen($this->name) > 255) {
            $errors['name'] = 'Category name must be under 255 characters.';
        }

        return $errors;
    }

    public function save(): bool
    {
        // Example persistence logic
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE categories SET name = ?, description = ?, updated_at = ? WHERE id = ?");
        return $stmt->execute([
            $this->name,
            $this->description,
            $this->updatedAt->format('Y-m-d H:i:s'),
            $this->id
        ]);
    }
}

?>