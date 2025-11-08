<?php
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

    public static function findByCSRandFilters(int $csrID, array $filters): array {
        $conn = self::connect();

        $sql = "SELECT id, userID, csrID, serviceType, completedAt, durationMinutes
                FROM requests
                WHERE csrID = ?";

        $types = "i";
        $params = [$csrID];

        if (!empty($filters['serviceType'])) {
            $sql .= " AND serviceType = ?";
            $types .= "s";
            $params[] = $filters['serviceType'];
        }

        if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
            $sql .= " AND DATE(completedAt) BETWEEN ? AND ?";
            $types .= "ss";
            $params[] = $filters['startDate'];
            $params[] = $filters['endDate'];
        }

        $sql .= " ORDER BY completedAt DESC";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Query prepare failed: " . $conn->error);
        }

        // Dynamically bind params
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

