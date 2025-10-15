<?php
require_once __DIR__ . '/../Utilities/DB.php';

class ServiceCategory {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }
	
	public function existsByName($name) {
		$sql = "SELECT 1 FROM service_categories WHERE name = ?";
		$stmt = mysqli_prepare($this->conn, $sql);
		mysqli_stmt_bind_param($stmt, "s", $name);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		$exists = mysqli_stmt_num_rows($stmt) > 0;
		mysqli_stmt_close($stmt);
		return $exists;
	}

	public function create($name, $description) {
		$sql = "INSERT INTO service_categories (name, description, status) VALUES (?, ?, 'active')";
		$stmt = mysqli_prepare($this->conn, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $name, $description);
		$success = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		return $success;
	}

	public function getAllCategories() {
    $sql = "SELECT * FROM service_categories WHERE status IN ('active', 'suspended') ORDER BY category_id ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    $stmt->close();
    return $categories;
}

	
		
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


	public function searchCategories($keyword) {
		$keyword = "%$keyword%";
		$stmt = $this->conn->prepare("SELECT * FROM service_categories WHERE name LIKE ? OR description LIKE ?");
		$stmt->bind_param("ss", $keyword, $keyword);
		$stmt->execute();
		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}
	
	
	public function updateCategory($categoryId, $name, $description) {
		$stmt = $this->conn->prepare("UPDATE service_categories SET name = ?, description = ? WHERE category_id = ?");
		$stmt->bind_param("ssi", $name, $description, $categoryId);
		return $stmt->execute();
	}
	
	public function suspendCategory($categoryId) {
		$stmt = $this->conn->prepare("UPDATE service_categories SET status = 'suspended' WHERE category_id = ?");
		$stmt->bind_param("i", $categoryId);
		return $stmt->execute();
	}

}
