<?php
class Request {
    public ?int $id = null;
    public int $userID;
    public string $title;
    public string $description;
    public string $priority;
    public string $status = 'Submitted';

    public function __construct(int $userID, string $title, string $description, string $priority) {
        $this->userID = $userID;
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
    }

    public function validate(): array {
        $errors = [];
        if (empty($this->title)) $errors[] = "Title is required.";
        if (empty($this->description)) $errors[] = "Description is required.";
        if (!in_array($this->priority, ['Low', 'Medium', 'High'])) {
            $errors[] = "Priority must be Low, Medium, or High.";
        }
        return $errors;
    }

    public function submit(): void {
        // Additional business logic for submission
        $this->status = 'Submitted';
    }

    public function save(): int {
        // Simulated save to DB, return request ID
        $this->id = rand(1000, 9999);
        return $this->id;
    }
}
?>
