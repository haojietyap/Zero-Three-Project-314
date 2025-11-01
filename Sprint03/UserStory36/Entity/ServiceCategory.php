<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ServiceCategory {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }
	
	public function delete($categoryId) {
		$stmt = $this->conn->prepare("UPDATE service_categories SET status = 'deleted' WHERE category_id = ?");
		$stmt->bind_param("i", $categoryId);
		return $stmt->execute();
	}

}
