<?php
require_once __DIR__ . '/database.php';

class Request {
    private static function connect(): mysqli {
        $host = "localhost";
        $username = "root";
        $password = ""; 
        $dbname = "zerothree";

        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    public static function findByCSRandFilters(int $csr_user_id, array $filters): array {
        $conn = self::connect();

        $sql = "
            SELECT m.match_id, m.request_id, m.csr_user_id, 
                   r.title, r.location, c.category_name, 
                   m.service_date, m.status
            FROM matches m
            JOIN requests r ON m.request_id = r.request_id
            JOIN service_categories c ON r.category_id = c.category_id
            WHERE m.csr_user_id = ?
        ";

        $types = "i";
        $params = [$csr_user_id];

        if (!empty($filters['category'])) {
            $sql .= " AND c.category_name LIKE ?";
            $types .= "s";
            $params[] = "%" . $filters['category'] . "%";
        }

        if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
            $sql .= " AND DATE(m.service_date) BETWEEN ? AND ?";
            $types .= "ss";
            $params[] = $filters['startDate'];
            $params[] = $filters['endDate'];
        }

        $sql .= " ORDER BY m.service_date DESC";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Query prepare failed: " . $conn->error);
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $requests;
    }
}
?>
