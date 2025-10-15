<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ConfirmedJob {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    
    public function addConfirmedJob($jobId, $cleanerId, $homeownerId, $matchedDate) {
        $sql = "INSERT INTO confirmed_jobs (job_id, cleaner_id, homeowner_id, matched_date)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiis", $jobId, $cleanerId, $homeownerId, $matchedDate);
        return $stmt->execute();
    }

  
	public function getJobsByCleaner($cleanerId) {
		$sql = "SELECT cj.*, cs.title AS service_title, u.name AS homeowner_name
				FROM confirmed_jobs cj
				JOIN cleaning_services cs ON cj.job_id = cs.job_id
				JOIN users u ON cj.homeowner_id = u.id
				WHERE cj.cleaner_id = ?";

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $cleanerId);
		$stmt->execute();
		return $stmt->get_result();
	}


	public function markAsCompleted($matchId) {
		$sql = "UPDATE confirmed_jobs SET status = 'completed', completion_date = CURDATE() WHERE match_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $matchId);
		return $stmt->execute();
	}

	
	public function filterJobsByCleanerWithStatus($cleanerId, $status) {
		$sql = "SELECT cj.*, cs.title AS service_title, u.name AS homeowner_name
				FROM confirmed_jobs cj
				JOIN cleaning_services cs ON cj.job_id = cs.job_id
				JOIN users u ON cj.homeowner_id = u.id
				WHERE cj.cleaner_id = ? AND cj.status = ?";
				
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("is", $cleanerId, $status);
		$stmt->execute();
		return $stmt->get_result();
	}


 
	public function getByHomeowner($homeownerId) {
		$sql = "SELECT cj.*, cs.title AS service_title, sc.name AS category_name, u.name AS cleaner_name
		FROM confirmed_jobs cj
		JOIN cleaning_services cs ON cj.job_id = cs.job_id
		JOIN service_categories sc ON cs.category_id = sc.category_id
		JOIN users u ON cs.cleaner_id = u.id
		WHERE cj.homeowner_id = ?";

	
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $homeownerId);
		$stmt->execute();
		return $stmt->get_result();
	}

	public function filterByHomeownerServiceAndDate($homeownerId, $categoryId, $startDate, $endDate) {
		$sql = "SELECT cj.*, cs.title AS service_title, sc.name AS category_name, u.name AS cleaner_name
				FROM confirmed_jobs cj
				JOIN cleaning_services cs ON cj.job_id = cs.job_id
				JOIN service_categories sc ON cs.category_id = sc.category_id
				JOIN users u ON cs.cleaner_id = u.id
				WHERE cj.homeowner_id = ? ";

		$types = "i";
		$params = [$homeownerId];

		if (!empty($categoryId)) {
			$sql .= " AND cs.category_id = ?";
			$types .= "i";
			$params[] = $categoryId;
		}

		if (!empty($startDate)) {
			$sql .= " AND cj.matched_date = ?";
			$types .= "s";
			$params[] = $startDate;
		}

		if (!empty($endDate)) {
			$sql .= " AND cj.completion_date IS NOT NULL AND cj.completion_date = ?";
			$types .= "s";
			$params[] = $endDate;
		}


		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param($types, ...$params);
		$stmt->execute();

		return $stmt->get_result();
	}

   
   public function countCompletedByService($cleanerId) {
		$sql = "SELECT sc.name AS category_name, COUNT(*) AS total
			FROM confirmed_jobs cj
			JOIN cleaning_services cs ON cj.job_id = cs.job_id
			JOIN service_categories sc ON cs.category_id = sc.category_id
			WHERE cj.cleaner_id = ? AND cj.status = 'completed'
			GROUP BY sc.name";

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $cleanerId);
		$stmt->execute();
		return $stmt->get_result();
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
	
	//Weekly Report
	public function getWeeklyCategoryStats() {
		$sql = "SELECT sc.name AS category_name, 
				COALESCE(COUNT(cj.job_id), 0) AS total_completed
				FROM service_categories sc
				LEFT JOIN cleaning_services cs ON sc.category_id = cs.category_id
				LEFT JOIN confirmed_jobs cj 
				ON cs.job_id = cj.job_id 
				AND cj.status = 'completed' 
				AND cj.completion_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()
				GROUP BY sc.category_id";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->get_result();
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
