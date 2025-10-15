<?php
require_once __DIR__ . '/../Utilities/DB.php';

class Favorite {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function addFavorite($homeownerId, $cleanerId) {
        $stmt = $this->conn->prepare("INSERT INTO favorites (homeowner_id, cleaner_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $homeownerId, $cleanerId);
        return $stmt->execute();
    }

    public function removeFavorite($homeownerId, $cleanerId) {
        $stmt = $this->conn->prepare("DELETE FROM favorites 
									WHERE homeowner_id = ? AND cleaner_id = ?");
        $stmt->bind_param("ii", $homeownerId, $cleanerId);
        return $stmt->execute();
    }

    public function isFavorited($homeownerId, $cleanerId) {
        $stmt = $this->conn->prepare("SELECT * FROM favorites 
									WHERE homeowner_id = ? AND cleaner_id = ?");
        $stmt->bind_param("ii", $homeownerId, $cleanerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
	
    public function getFavoritesByHomeowner($homeownerId) {
       $stmt = $this->conn->prepare("SELECT u.id AS cleaner_id, u.name, sc.name AS category_name
									FROM favorites f
									JOIN users u ON f.cleaner_id = u.id
									LEFT JOIN cleaner_profiles cp ON cp.user_id = u.id
									LEFT JOIN service_categories sc ON cp.expertise = sc.category_id
									WHERE f.homeowner_id = ?
									AND cp.status = 'active'
									AND u.status = 'active'");
									
        $stmt->bind_param("i", $homeownerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
	
	public function searchFavoritesByHomeowner($homeownerId, $keyword) {
		$sql = "SELECT u.id AS cleaner_id, u.name, sc.name AS category_name
				FROM favorites f
				JOIN users u ON f.cleaner_id = u.id
				JOIN cleaner_profiles cp ON cp.user_id = u.id
				JOIN service_categories sc ON cp.expertise = sc.category_id
				WHERE f.homeowner_id = ?
				AND (u.name LIKE ? OR sc.name LIKE ?)";

		$stmt = $this->conn->prepare($sql);
		$like = "%$keyword%";
		$stmt->bind_param("iss", $homeownerId, $like, $like);
		$stmt->execute();
		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

}
?>
