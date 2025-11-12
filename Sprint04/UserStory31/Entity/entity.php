<?php
require_once __DIR__ . '/../database.php';

class CompletedService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Find completed services by CSR with filters
    public function findByCsrAndFilters($csrID, $filters = []) {
        try {
            $sql = "SELECT completed_service_id, request_id, csr_user_id, service_type, duration_minutes, completed_at
                    FROM completed_services
                    WHERE csr_user_id = :csrID";

            $params = [':csrID' => $csrID];

            if (!empty($filters['keyword'])) {
                $sql .= " AND (service_type LIKE :keyword)";
                $params[':keyword'] = "%" . $filters['keyword'] . "%";
            }

            if (!empty($filters['serviceType'])) {
                $sql .= " AND service_type LIKE :serviceType";
                $params[':serviceType'] = "%" . $filters['serviceType'] . "%";
            }

            if (!empty($filters['date'])) {
                $sql .= " AND DATE(completed_at) = :date";
                $params[':date'] = $filters['date'];
            }

            $sql .= " ORDER BY completed_at DESC";

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
