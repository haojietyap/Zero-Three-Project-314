<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ConsultationService {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function createService($CSRId, $title, $description, $categoryId, $price) {
		$sql = "INSERT INTO consultation_services 
				(CSR_id, title, description, category_id, price, status, views, shortlisted)
				VALUES (?, ?, ?, ?, ?, 'offered', 0, 0)";

		$stmt = mysqli_prepare($this->conn, $sql);

		if (!$stmt) {
        return false;
    }

		mysqli_stmt_bind_param($stmt, "issid", $CSRId, $title, $description, $categoryId, $price);
		$success = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);

		return $success;
	}

	public function getServicesByCSR($CSRId) {
		$sql = "SELECT cs.*, sc.name AS category_name
				FROM consultation_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.cleaner_id = ? 
				AND cs.status IN ('offered', 'suspended')
				AND sc.status = 'active'";
    
		$stmt = mysqli_prepare($this->conn, $sql);

		if (!$stmt) {
        return [];
    }

		mysqli_stmt_bind_param($stmt, "i", $CSRId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$services = [];
		while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }

		mysqli_stmt_close($stmt);
		return $services;
	}
	
	public function getOfferedServicesByCSR($CSRId) { //PIN
		$sql = "SELECT cs.*, sc.name AS category_name
				FROM consultation_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.CSR_id = ?
				AND cs.status = 'offered'
				AND sc.status = 'active'";

		$stmt = mysqli_prepare($this->conn, $sql);

		if (!$stmt) {
        return [];
		}

		mysqli_stmt_bind_param($stmt, "i", $CSRId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$services = [];
		while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
		}

		mysqli_stmt_close($stmt);
		return $services;
	}


	public function searchServicesByTitle($CSRId, $keyword) {
		$sql = "SELECT cs.*, sc.name AS category_name
				FROM consultation_services cs
				LEFT JOIN service_categories sc ON cs.category_id = sc.category_id
				WHERE cs.CSR_id = ?
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
		mysqli_stmt_bind_param($stmt, "isss", $CSRId, $searchTerm, $searchTerm, $searchTerm);
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
		$sql = "UPDATE consultation_services 
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
		$sql = "SELECT * FROM consultation_services WHERE job_id = ?";
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
		$sql = "UPDATE consultation_services SET status = 'suspended' WHERE job_id = ?";
		$stmt = mysqli_prepare($this->conn, $sql);
		mysqli_stmt_bind_param($stmt, 'i', $jobId);
		return mysqli_stmt_execute($stmt);
	
	}

	public function unsuspendService($jobId) {
		$sql = "UPDATE consultation_services SET status = 'offered' WHERE job_id = ?";
		$stmt = mysqli_prepare($this->conn, $sql);
		mysqli_stmt_bind_param($stmt, 'i', $jobId);
		return mysqli_stmt_execute($stmt);
	}

	public function incrementViewCountIfNew($jobId, $PINId) {
		$checkSql = "SELECT 1 FROM service_views WHERE job_id = ? AND PIN_id = ?";
		$stmt = $this->conn->prepare($checkSql);
		$stmt->bind_param("ii", $jobId, $PINId);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows === 0) {
       
		$insertSql = "INSERT INTO service_views (job_id, PIN_id) VALUES (?, ?)";
		$insertStmt = $this->conn->prepare($insertSql);
		$insertStmt->bind_param("ii", $jobId, $PINId);
		$insertStmt->execute();

		$updateSql = "UPDATE consultation_services SET views = views + 1 WHERE job_id = ?";
		$updateStmt = $this->conn->prepare($updateSql);
		$updateStmt->bind_param("i", $jobId);
		return $updateStmt->execute();
		}

		return false; 
	}

}

