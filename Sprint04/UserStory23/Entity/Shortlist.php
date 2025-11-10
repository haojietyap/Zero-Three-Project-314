<?php
require_once __DIR__ . '/../database.php';

class Shortlist
{
    public int $csr_user_id;
    public int $request_id;
    public DateTime $shortlisted_at;

    public string $title;
    public string $location;
    public string $category_name;
    public string $preferred_date;

    private mysqli $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "zerothree");
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function findByCSRandFilters(int $csr_user_id, array $filters): array
    {
        $sql = "
            SELECT s.csr_user_id, s.request_id, s.shortlisted_at,
                   r.title, r.location, c.category_name, r.preferred_date
            FROM request_shortlists s
            JOIN requests r ON s.request_id = r.request_id
            JOIN service_categories c ON r.category_id = c.category_id
            WHERE s.csr_user_id = ?
        ";

        $params = [$csr_user_id];
        $types = "i";

        if (!empty($filters['location'])) {
            $sql .= " AND r.location LIKE ?";
            $params[] = "%" . $filters['location'] . "%";
            $types .= "s";
        }

        if (!empty($filters['category'])) {
            $sql .= " AND c.category_name LIKE ?";
            $params[] = "%" . $filters['category'] . "%";
            $types .= "s";
        }

        if (!empty($filters['date'])) {
            $sql .= " AND r.preferred_date = ?";
            $params[] = $filters['date'];
            $types .= "s";
        }

        $sql .= " ORDER BY s.shortlisted_at DESC";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) die("Query preparation failed: " . $this->conn->error);

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $item = new Shortlist();
            $item->csr_user_id = (int)$row['csr_user_id'];
            $item->request_id = (int)$row['request_id'];
            $item->shortlisted_at = new DateTime($row['shortlisted_at']);

            $item->title = $row['title'];
            $item->location = $row['location'];
            $item->category_name = $row['category_name'];
            $item->preferred_date = $row['preferred_date'];

            $rows[] = $item;
        }

        $stmt->close();
        return $rows;
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}
?>
