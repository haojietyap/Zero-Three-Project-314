<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ServiceCategory {
    private $conn;
		
	public function getCategoryById($categoryId) {
		$sql = "SELECT * FROM service_categories WHERE category_id = ? AND status = 'active'";
		$stmt = mysqli_prepare($this->conn, $sql);
		mysqli_stmt_bind_param($stmt, "i", $categoryId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$category = mysqli_fetch_assoc($result);
		mysqli_stmt_close($stmt);
		return $category;
	}
	
	public function updateCategory($categoryId, $name, $description) {
		$stmt = $this->conn->prepare("UPDATE service_categories SET name = ?, description = ? WHERE category_id = ?");
		$stmt->bind_param("ssi", $name, $description, $categoryId);
		return $stmt->execute();
	}
	
}
