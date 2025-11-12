<?php
require_once __DIR__ . '/../database.php';

class Shortlist {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Find all shortlists for a given CSR
    public function findByCsr($csrID) {
        try {
            $sql = "SELECT shortlist_id, csr_user_id, request_id, shortlisted_at
                    FROM request_shortlists
                    WHERE csr_user_id = :csrID
                    ORDER BY shortlisted_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':csrID', $csrID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
            return [];
        }
    }

    // Add new request to CSR shortlist
    public function addToShortlist($csrID, $requestID) {
        try {
            // Check if already exists
            $check = $this->conn->prepare(
                "SELECT * FROM request_shortlists WHERE csr_user_id = :csrID AND request_id = :requestID"
            );
            $check->execute([':csrID' => $csrID, ':requestID' => $requestID]);
            if ($check->rowCount() > 0) {
                return ['success' => false, 'message' => 'Request already in shortlist.'];
            }

            // Insert new shortlist entry
            $sql = "INSERT INTO request_shortlists (csr_user_id, request_id, shortlisted_at)
                    VALUES (:csrID, :requestID, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':csrID' => $csrID, ':requestID' => $requestID]);

            return ['success' => true, 'message' => 'Request successfully added to shortlist.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
?>
