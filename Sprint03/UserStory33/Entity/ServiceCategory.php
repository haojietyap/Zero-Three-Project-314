<?php

class ServiceCategory {
    private ?int $id = null;                     
    private string $name = '';                   
    private string $description = '';           
    private ?DateTimeImmutable $createdAt = null; 

    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
        if (!$this->conn) {
            throw new RuntimeException("Database connection failed.");
        }
    }

    public function setName(string $name): void {
        $this->name = trim($name);
    }

    public function setDescription(string $description): void {
        $this->description = trim($description);
    }


    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCreatedAt(): ?DateTimeImmutable {
        return $this->createdAt;
    }


    public function validate(): array {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = "Name cannot be empty.";
        } elseif (strlen($this->name) > 255) { 
            $errors['name'] = "Name must be less than 255 characters.";
        }

        if (empty($this->description)) {
            $errors['description'] = "Description cannot be empty.";
        }

        if (!empty($this->name) && $this->existsByName($this->name)) {
            $errors['name'] = "Category with this name already exists.";
        }

        return $errors;
    }


    public function save(): int {
        $sql = "INSERT INTO service_categories (name, description, status, created_at) 
                VALUES (?, ?, 'active', NOW())";

        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            error_log("Failed to prepare statement: " . mysqli_error($this->conn));
            return 0;
        }

        mysqli_stmt_bind_param($stmt, "ss", $this->name, $this->description);

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
        $sql = "SELECT 1 FROM service_categories WHERE name = ? LIMIT 1";
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
