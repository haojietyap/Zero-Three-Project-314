<?php
require_once __DIR__ . '/../Utilities/DB.php';

class Favorite {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    public function addFavorite($PINId, $CSRId) {
        $stmt = $this->conn->prepare("INSERT INTO favorites (PIN_id, CSR_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $PINId, $CSRId);
        return $stmt->execute();
    }

    public function removeFavorite($PINId, $CSRId) {
        $stmt = $this->conn->prepare("DELETE FROM favorites 
									WHERE PIN_id = ? AND CSR_id = ?");
        $stmt->bind_param("ii", $PINId, $CSRId);
        return $stmt->execute();
    }

    public function isFavorited($PINId, $CSRId) {
        $stmt = $this->conn->prepare("SELECT * FROM favorites 
									WHERE PIN_id = ? AND CSR_id = ?");
        $stmt->bind_param("ii", $PINId, $CSRId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
	
    public function getFavoritesByPIN($PIN) {
       $stmt = $this->conn->prepare("SELECT u.id AS CSR_id, u.name, sc.name AS category_name
									FROM favorites f
									JOIN users u ON f.CSR_id = u.id
									LEFT JOIN CSR_profiles cp ON cp.user_id = u.id
									LEFT JOIN service_categories sc ON cp.expertise = sc.category_id
									WHERE f.PIN_id = ?
									AND cp.status = 'active'
									AND u.status = 'active'");
									
        $stmt->bind_param("i", PINId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
	
	public function searchFavoritesByPIN($PINId, $keyword) {
		$sql = "SELECT u.id AS CSR_id, u.name, sc.name AS category_name
				FROM favorites f
				JOIN users u ON f.CSR_id = u.id
				JOIN CSR_profiles cp ON cp.user_id = u.id
				JOIN service_categories sc ON cp.expertise = sc.category_id
				WHERE f.PIN_id = ?
				AND (u.name LIKE ? OR sc.name LIKE ?)";

		$stmt = $this->conn->prepare($sql);
		$like = "%$keyword%";
		$stmt->bind_param("iss", $PINId, $like, $like);
		$stmt->execute();
		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

}
?>

