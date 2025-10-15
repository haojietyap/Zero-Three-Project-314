<?php
require_once __DIR__ . '/../Utilities/DB.php';

class Shortlists {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function addToShortlist($homeownerId, $jobId) {
        $checkSql = "SELECT 1 FROM shortlists WHERE homeowner_id = ? AND job_id = ?";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->bind_param("ii", $homeownerId, $jobId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $insertSql = "INSERT INTO shortlists (homeowner_id, job_id) VALUES (?, ?)";
            $insertStmt = $this->conn->prepare($insertSql);
            $insertStmt->bind_param("ii", $homeownerId, $jobId);
            return $insertStmt->execute();
        }

        return false; 
    }

   
    public function countShortlistsByJobId($jobId) {
        $sql = "SELECT COUNT(*) AS total FROM shortlists WHERE job_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $jobId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

}
