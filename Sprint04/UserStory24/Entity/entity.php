<?php
require_once __DIR__ . '/../database.php';

class Shortlist {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Find all shortlisted requests (with optional filters)
    public function findByCsr($csrID, $filters = []) {
        try {
            $sql = "SELECT s.shortlist_id, s.request_id, s.shortlisted_at,
                           r.title, r.description, r.location, r.status, r.preferred_date
                    FROM request_shortlists s
                    JOIN requests r ON s.request_id = r.request_id
                    WHERE s.csr_user_id = :csrID";

            $params = [':csrID' => $csrID];

            if (!empty($filters['status'])) {
                $sql .= " AND r.status = :status";
                $params[':status'] = $filters['status'];
            }

            if (!empty($filters['location'])) {
                $sql .= " AND r.location LIKE :location";
                $params[':location'] = "%" . $filters['location'] . "%";
            }

            $sql .= " ORDER BY s.shortlisted_at DESC";

            $stmt = $this->conn->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return [];
        }
    }
}
?>
