<?php
require_once __DIR__ . '/database.php';

class Request {
    public int $request_id;
    public int $pin_user_id;
    public string $title;
    public string $category_name;
    public string $status;
    public DateTime $created_at;

    public static function findByFilters(array $filters): array {
        $pin = $filters['pin_user_id'];
        $status = $filters['status'] ?? null;

        $sql = "SELECT r.request_id, r.pin_user_id, r.title, c.category_name, 
                       r.status, r.created_at
                FROM requests r
                JOIN service_categories c ON r.category_id = c.category_id
                WHERE r.pin_user_id = :pin";
        $params = [':pin' => $pin];

        if (!empty($status)) {
            $sql .= " AND r.status = :status";
            $params[':status'] = $status;
        }

        $rows = Database::query($sql, $params);
        $requests = [];

        foreach ($rows as $row) {
            $r = new Request();
            $r->request_id = $row['request_id'];
            $r->pin_user_id = $row['pin_user_id'];
            $r->title = $row['title'];
            $r->category_name = $row['category_name'];
            $r->status = $row['status'];
            $r->created_at = new DateTime($row['created_at']);
            $requests[] = $r;
        }

        return $requests;
    }
}
?>
