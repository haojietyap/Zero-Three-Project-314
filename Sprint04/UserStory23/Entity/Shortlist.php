<?php
class Shortlist
{
    private $conn;

    public function __construct()
    {
        // ✅ Database connection (MySQLi)
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "zerothree";

        $this->conn = new mysqli($host, $user, $pass, $db);

        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function findByCSRAndFilters(int $csrId, array $filters): array
    {
        // Base query
        $sql = "
            SELECT s.csrId, s.requestId, s.savedAt,
                   v.title, v.location, v.category, v.date
            FROM shortlist s
            JOIN volunteer_opportunities v ON s.requestId = v.id
            WHERE s.csrId = ?
        ";

        // Parameters and types
        $params = [$csrId];
        $types = "i"; // csrId is integer

        // 🧩 Add filters dynamically
        if (!empty($filters['location'])) {
            $sql .= " AND v.location LIKE ?";
            $params[] = "%" . $filters['location'] . "%";
            $types .= "s";
        }

        if (!empty($filters['category'])) {
            $sql .= " AND v.category LIKE ?";
            $params[] = "%" . $filters['category'] . "%";
            $types .= "s";
        }

        if (!empty($filters['date'])) {
            $sql .= " AND v.date = ?";
            $params[] = $filters['date'];
            $types .= "s";
        }

        $sql .= " ORDER BY s.savedAt DESC";

        // Prepare and bind
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Query preparation failed: " . $this->conn->error);
        }

        // Dynamically bind parameters
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
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
