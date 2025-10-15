<?php
require_once __DIR__ . '/../Utilities/DB.php';

class AdminProfile {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }
	
	public function exists($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM admin_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}
	
	public function create($userId, $phone, $address) {
		$stmt = $this->conn->prepare("INSERT INTO admin_profiles (user_id, phone, address, status) VALUES (?, ?, ?, 'active')");
		$stmt->bind_param("iss", $userId, $phone, $address);
		return $stmt->execute();
	}
	
	public function hasAdminManagerProfile($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM admin_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}
	
	
    public function getProfileByUserId($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM admin_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}
	
	public function updateProfile($userId, $phone, $address) {
    $stmt = $this->conn->prepare("UPDATE admin_profiles 
								SET phone = ?, address = ?
								WHERE user_id = ?");
    $stmt->bind_param("ssi", $phone, $address, $userId);
    return $stmt->execute();
	}

	
	public function suspendProfile($userId) {
		$sql = "UPDATE admin_profiles SET status = 'suspended' WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $userId);

		return $stmt->execute();
	}
	
}
	
	
	
	
	
	
