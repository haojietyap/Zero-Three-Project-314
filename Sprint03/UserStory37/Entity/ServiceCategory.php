<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ServiceCategory {
    private $conn;
		
	public function searchCategories($keyword) {
		$keyword = "%$keyword%";
		$stmt = $this->conn->prepare("SELECT * FROM service_categories WHERE name LIKE ? OR description LIKE ?");
		$stmt->bind_param("ss", $keyword, $keyword);
		$stmt->execute();
		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}
	
}
