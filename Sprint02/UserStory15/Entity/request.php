<?php
class Request {
    public int $id;
    public string $title;
    public string $description;
    public string $priority;
    public string $status;
    public string $updatedAt;

    private static array $requests = [];

    public static function seed(array $data): void {
        self::$requests = $data;
    }

    public static function findByID(int $requestID): ?self {
        foreach (self::$requests as $r) {
            if ($r['id'] === $requestID) {
                $req = new self();
                $req->id = $r['id'];
                $req->title = $r['title'];
                $req->description = $r['description'];
                $req->priority = $r['priority'];
                $req->status = $r['status'];
                $req->updatedAt = $r['updatedAt'];
                return $req;
            }
        }
        return null;
    }

    public function updateForm(array $data): void {
        $this->title = $data['title'] ?? $this->title;
        $this->description = $data['description'] ?? $this->description;
        $this->priority = $data['priority'] ?? $this->priority;
        $this->status = $data['status'] ?? $this->status;
    }

    public function validateUpdate(): array {
        $errors = [];
        if (empty($this->title)) $errors[] = "Title cannot be empty.";
        if (empty($this->description)) $errors[] = "Description cannot be empty.";
        return $errors;
    }

    public function save(): bool {
        foreach (self::$requests as &$r) {
            if ($r['id'] === $this->id) {
                $r['title'] = $this->title;
                $r['description'] = $this->description;
                $r['priority'] = $this->priority;
                $r['status'] = $this->status;
                $r['updatedAt'] = date("Y-m-d H:i:s");
                return true;
            }
        }
        return false;
    }

    public static function all(): array {
        return self::$requests;
    }
}
?>
