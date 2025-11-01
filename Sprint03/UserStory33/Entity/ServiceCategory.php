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

    // Setters
    public function setName(string $name): void {
        $this->name = trim($name);
    }

    public function setDescription(string $description): void {
        $this->description = trim($description);
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCreatedAt(): DateTimeImmutable {
        return $this->createdAt;
    }

    public function validate(): array {
        $errors = [];

        if (empty($this->name)) {
            $errors[] = "Name cannot be empty.";
        }

        if (empty($this->description)) {
            $errors[] = "Description cannot be empty.";
        }

        // Optionally check if name already exists in DB
        if (!empty($this->name) && $this->existsByName($this->name)) {
            $errors[] = "Category with this name already exists.";
        }

        return $errors;
    }

    public function save(): int {
        $sql = "INSERT INTO service_categories (name, description, status, created_at) 
                VALUES (?, ?, 'active', NOW())";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $this->name, $this->description);

        if (mysqli_stmt_execute($stmt)) {
            $newId = mysqli_insert_id($this->conn);
            $this->id = (int) $newId;
            $this->createdAt = new DateTimeImmutable(); // assume NOW()
            mysqli_stmt_close($stmt);
            return $this->id;
        }

        mysqli_stmt_close($stmt);
        return 0;
    }

    private function existsByName(string $name): bool {
        $sql = "SELECT 1 FROM service_categories WHERE name = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $exists = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);
        return $exists;
    }
}
