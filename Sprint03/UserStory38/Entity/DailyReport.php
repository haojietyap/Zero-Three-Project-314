<?php
require_once __DIR__ . '/../Utilities/DB.php';

class DailyJobReport {
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


	//Daily Report
	public function countConfirmedToday() {
		$today = date('Y-m-d');
		$sql = "SELECT COUNT(*) AS total FROM confirmed_jobs WHERE matched_date = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $today);
		$stmt->execute();
		return $stmt->get_result();
	}
	

}
