<?php
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


    public static function findByCSR(int $csrID, array $filters = []): array {
        $conn = self::connect();

        $sql = "SELECT s.csrID, s.requestID, s.savedAt, r.userID, r.serviceType, r.completedAt, r.durationMinutes
                FROM shortlist s
                INNER JOIN requests r ON r.id = s.requestID
                WHERE s.csrID = ?";

        $types = "i";
        $params = [$csrID];

        // Optional filter: serviceType
        if (!empty($filters['serviceType'])) {
            $sql .= " AND r.serviceType = ?";
            $types .= "s";
            $params[] = $filters['serviceType'];
        }

        // Optional filter: date range
        if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
            $sql .= " AND DATE(s.savedAt) BETWEEN ? AND ?";
            $types .= "ss";
            $params[] = $filters['startDate'];
            $params[] = $filters['endDate'];
        }

        $sql .= " ORDER BY s.savedAt DESC";

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
