<?php
require_once __DIR__ . '/../Utilities/DB.php';

class MonthlyJobReport {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    
    public function addConfirmedJob($jobId, $CSRId, $PINId, $matchedDate) {
        $sql = "INSERT INTO confirmed_jobs (job_id, CSR_id, PIN_id, matched_date)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiis", $jobId, $CSRId, $PINId, $matchedDate);
        return $stmt->execute();
    }

	//Monthly Report 
	public function getMonthlyStats() {
    $sql = "SELECT 
            COUNT(DISTINCT cleaner_id) AS active_cleaners, 
            COUNT(*) AS completed_jobs
			FROM confirmed_jobs
			WHERE status = 'completed'
			AND completion_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->get_result();
	}

}
