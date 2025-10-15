<?php
require_once __DIR__ . '/../Utilities/DB.php';

class CleaningService {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function createService($cleanerId, $title, $description, $categoryId, $price) {
		$sql = "INSERT INTO cleaning_services 
				(cleaner_id, title, description, category_id, price, status, views, shortlisted)
				VALUES (?, ?, ?, ?, ?, 'offered', 0, 0)";

		$stmt = mysqli_prepare($this->conn, $sql);

		if (!$stmt) {
        return false;
    }

		mysqli_stmt_bind_param($stmt, "issid", $cleanerId, $title, $description, $categoryId, $price);
		$success = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);

		return $success;
	}

	public function getServicesByCleaner($cleanerId) {
		$sql = "SELECT cs.*, sc.name AS category_name
				FROM cleaning_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.cleaner_id = ? 
				AND cs.status IN ('offered', 'suspended')
				AND sc.status = 'active'";
    
		$stmt = mysqli_prepare($this->conn, $sql);

		if (!$stmt) {
        return [];
    }

		mysqli_stmt_bind_param($stmt, "i", $cleanerId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$services = [];
		while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }

		mysqli_stmt_close($stmt);
		return $services;
	}
	
	public function getOfferedServicesByCleaner($cleanerId) { //Homeowner
		$sql = "SELECT cs.*, sc.name AS category_name
				FROM cleaning_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.cleaner_id = ?
				AND cs.status = 'offered'
				AND sc.status = 'active'";

		$stmt = mysqli_prepare($this->conn, $sql);

		if (!$stmt) {
        return [];
		}

		mysqli_stmt_bind_param($stmt, "i", $cleanerId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$services = [];
		while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
		}

		mysqli_stmt_close($stmt);
		return $services;
	}


	public function searchServicesByTitle($cleanerId, $keyword) {
		$sql = "SELECT cs.*, sc.name AS category_name
				FROM cleaning_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.cleaner_id = ?
				AND (
                cs.title LIKE ? OR 
                cs.description LIKE ? OR 
                sc.name LIKE ?
				)
				ORDER BY cs.job_id ASC";

		$stmt = mysqli_prepare($this->conn, $sql);

		if (!$stmt) {
        return [];
    }

		$searchTerm = '%' . $keyword . '%';
		mysqli_stmt_bind_param($stmt, "isss", $cleanerId, $searchTerm, $searchTerm, $searchTerm);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$services = [];
		while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }

		mysqli_stmt_close($stmt);
		return $services;
	}


	public function updateService($jobId, $title, $description, $categoryId, $price) {
		$sql = "UPDATE cleaning_services 
				SET title = ?, description = ?, category_id = ?, price = ?
				WHERE job_id = ?";

		$stmt = mysqli_prepare($this->conn, $sql);
		if (!$stmt) return false;

		mysqli_stmt_bind_param($stmt, "ssdii", $title, $description, $categoryId, $price, $jobId);
		$success = mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);
		return $success;
	}

	public function getServiceById($jobId) {
		$sql = "SELECT * FROM cleaning_services WHERE job_id = ?";
		$stmt = mysqli_prepare($this->conn, $sql);
		if (!$stmt) return null;

		mysqli_stmt_bind_param($stmt, "i", $jobId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$service = mysqli_fetch_assoc($result);

		mysqli_stmt_close($stmt);
		return $service;
	}

	public function suspendService($jobId) {
		$sql = "UPDATE cleaning_services SET status = 'suspended' WHERE job_id = ?";
		$stmt = mysqli_prepare($this->conn, $sql);
		mysqli_stmt_bind_param($stmt, 'i', $jobId);
		return mysqli_stmt_execute($stmt);
	
	}

	public function unsuspendService($jobId) {
		$sql = "UPDATE cleaning_services SET status = 'offered' WHERE job_id = ?";
		$stmt = mysqli_prepare($this->conn, $sql);
		mysqli_stmt_bind_param($stmt, 'i', $jobId);
		return mysqli_stmt_execute($stmt);
	}

	public function incrementViewCountIfNew($jobId, $homeownerId) {
		$checkSql = "SELECT 1 FROM service_views WHERE job_id = ? AND homeowner_id = ?";
		$stmt = $this->conn->prepare($checkSql);
		$stmt->bind_param("ii", $jobId, $homeownerId);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows === 0) {
       
		$insertSql = "INSERT INTO service_views (job_id, homeowner_id) VALUES (?, ?)";
		$insertStmt = $this->conn->prepare($insertSql);
		$insertStmt->bind_param("ii", $jobId, $homeownerId);
		$insertStmt->execute();

		$updateSql = "UPDATE cleaning_services SET views = views + 1 WHERE job_id = ?";
		$updateStmt = $this->conn->prepare($updateSql);
		$updateStmt->bind_param("i", $jobId);
		return $updateStmt->execute();
		}

		return false; 
	}

}
