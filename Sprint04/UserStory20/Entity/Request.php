<?php
require_once __DIR__ . '/../Database.php';

class Request {
    public int $id;
    public int $userID;
    public string $title;
    public string $category;
    public string $status;
    public DateTime $createdAt;

    public static function findByFilters(array $filters): array {
        $pin = $filters['PIN'];
        $status = $filters['status'] ?? null;

        $sql = "SELECT * FROM requests WHERE userID = :pin";
        $params = [':pin' => $pin];

        if (!empty($status)) {
            $sql .= " AND status = :status";
            $params[':status'] = $status;
        }

        // Example: Use Database::query() to fetch results
        $rows = Database::query($sql, $params);
        $requests = [];

        foreach ($rows as $row) {
            $r = new Request();
            $r->id = $row['id'];
            $r->userID = $row['userID'];
            $r->title = $row['title'];
            $r->category = $row['category'];
            $r->status = $row['status'];
            $r->createdAt = new DateTime($row['createdAt']);
            $requests[] = $r;
        }

        return $requests;
    }
}
?>

