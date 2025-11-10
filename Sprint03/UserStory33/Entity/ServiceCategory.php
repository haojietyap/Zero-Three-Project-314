<?php

require_once __DIR__ . '/database.php';

class ServiceCategory {
    private ?int $id = null;
    private string $name = '';
    private string $description = '';
    private bool $isActive = true;
    private ?DateTimeImmutable $createdAt = null;

    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
        if (!$this->conn) {
            throw new RuntimeException("Database connection failed.");
        }
    }

    public function createCategory(array $data): array {
        $this->setName(trim($data['name'] ?? ''));
        $this->setDescription(trim($data['description'] ?? ''));

        $errors = $this->validate();

        if (!empty($errors)) {
            if (isset($errors['name']) && stripos($errors['name'], 'exists') !== false) {
                return ['status' => 'exists', 'id' => null, 'errors' => $errors];
            }
            return ['status' => 'error', 'id' => null, 'errors' => $errors];
        }

        $newId = $this->save();

        return $newId
            ? ['status' => 'success', 'id' => $newId]
            : ['status' => 'error', 'id' => null];
    }

    private function setName(string $name): void {
        $this->name = $name;
    }

    private function setDescription(string $description): void {
        $this->description = $description;
    }

    private function validate(): array {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = "Name cannot be empty.";
        } elseif (strlen($this->name) > 100) { // DB limit is 100
            $errors['name'] = "Name must be less than 100 characters.";
        }

        if (empty($this->description)) {
            $errors['description'] = "Description cannot be empty.";
        }

        if (!empty($this->name) && $this->existsByName($this->name)) {
            $errors['name'] = "Category with this name already exists.";
        }

        return $errors;
    }

    private function save(): int {
        $sql = "INSERT INTO service_categories (category_name, description, is_active, created_at)
                VALUES (?, ?, ?, NOW())";

        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            error_log("Failed to prepare statement: " . mysqli_error($this->conn));
            return 0;
        }

        $isActiveInt = $this->isActive ? 1 : 0;
        mysqli_stmt_bind_param($stmt, "ssi", $this->name, $this->description, $isActiveInt);

        if (mysqli_stmt_execute($stmt)) {
            $newId = mysqli_insert_id($this->conn);
            $this->id = (int)$newId;
            $this->createdAt = new DateTimeImmutable();
            mysqli_stmt_close($stmt);
            return $this->id;
        } else {
            error_log("Failed to insert service category: " . mysqli_error($this->conn));
        }

        mysqli_stmt_close($stmt);
        return 0;
    }

    private function existsByName(string $name): bool {
        $sql = "SELECT 1 FROM service_categories WHERE category_name = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            error_log("Failed to prepare existsByName(): " . mysqli_error($this->conn));
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $exists = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);

        return $exists;
    }
}
?>
