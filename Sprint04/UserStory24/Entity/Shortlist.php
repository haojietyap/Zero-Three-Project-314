<?php
require_once __DIR__ . '/../database.php';

class Shortlist {
    private static function connect(): mysqli {
        $host = "localhost";
        $username = "root";
        $password = ""; 
        $database = "zerothree";

        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        return $conn;
    }

    public static function findByCSR(int $csr_user_id, array $filters = []): array {
        $conn = self::connect();

        $sql = "
            SELECT s.csr_user_id, s.request_id, s.shortlisted_at,
                   r.title, r.location, c.category_name, r.preferred_date, r.status
            FROM request_shortlists s
            INNER JOIN requests r ON r.request_id = s.request_id
            INNER JOIN service_categories c ON r.category_id = c.category_id
            WHERE s.csr_user_id = ?
        ";

        $types = "i";
        $params = [$csr_user_id];

        // Optional filters
        if (!empty($filters['category'])) {
            $sql .= " AND c.category_name LIKE ?";
            $types .= "s";
            $params[] = "%" . $filters['category'] . "%";
        }

        if (!empty($filters['location'])) {
            $sql .= " AND r.location LIKE ?";
            $types .= "s";
            $params[] = "%" . $filters['location'] . "%";
        }

        if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
            $sql .= " AND DATE(r.preferred_date) BETWEEN ? AND ?";
            $types .= "ss";
            $params[] = $filters['startDate'];
            $params[] = $filters['endDate'];
        }

        $sql .= " ORDER BY s.shortlisted_at DESC";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Query prepare failed: " . $conn->error);
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $shortlist = [];
        while ($row = $result->fetch_assoc()) {
            $shortlist[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $shortlist;
    }
}
?>
