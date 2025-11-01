<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ServiceCategory {
    private int $id;
    private string $name;
    private string $description;
    private DateTimeImmutable $createdAt;

    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function findAll(): array {
        $sql = "SELECT category_id, name, description, created_at FROM service_categories 
                WHERE status IN ('active', 'suspended') ORDER BY category_id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $this->mapRowToObject($row);
        }

        $stmt->close();
        return $categories;
    }

    public function findById(int $categoryId): ?ServiceCategory {
        $sql = "SELECT category_id, name, description, created_at 
                FROM service_categories 
                WHERE category_id = ? AND status = 'active'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ? $this->mapRowToObject($row) : null;
    }

    private function mapRowToObject(array $row): ServiceCategory {
        $obj = new ServiceCategory();
        $obj->id = (int) $row['category_id'];
        $obj->name = $row['name'];
        $obj->description = $row['description'];
        $obj->createdAt = new DateTimeImmutable($row['created_at']);
        return $obj;
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getCreatedAt(): DateTimeImmutable { return $this->createdAt; }
}
