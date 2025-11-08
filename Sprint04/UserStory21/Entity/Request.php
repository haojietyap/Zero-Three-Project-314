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

        $rows = Database::query($sql, $params);
        $requests = [];

        foreach ($rows as $row) {
            $req = new Request();
            $req->id = $row['id'];
            $req->userID = $row['userID'];
            $req->title = $row['title'];
            $req->category = $row['category'];
            $req->status = $row['status'];
            $req->createdAt = new DateTime($row['createdAt']);
            $requests[] = $req;
        }

        return $requests;
    }
}
?>