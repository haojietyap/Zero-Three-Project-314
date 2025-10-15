<?php
require_once __DIR__ . '/../Utilities/DB.php';

class HomeownerProfile {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }
	
	public function exists($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM homeowner_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}

	public function create($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference) {
		$stmt = $this->conn->prepare("INSERT INTO homeowner_profiles (user_id, phone, address, preferred_cleaning_time, cleaning_frequency, language_preference, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
		$stmt->bind_param("isssss", $userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference);
		return $stmt->execute();
	}


	public function hasHomeownerProfile($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM homeowner_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}


    public function getProfileByUserId($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM homeowner_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}
	
	public function updateProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference) {
		$stmt = $this->conn->prepare("UPDATE homeowner_profiles 
									SET phone = ?, address = ?, preferred_cleaning_time = ?, cleaning_frequency = ?, language_preference = ? 
									WHERE user_id = ?");
									
		$stmt->bind_param("sssssi", $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $userId);
		return $stmt->execute();
	}

	public function suspendProfile($userId) {
		$sql = "UPDATE homeowner_profiles SET status = 'suspended' WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $userId);

		return $stmt->execute();
	}
	
	public function unsuspendProfile($userId) {
		$sql = "UPDATE homeowner_profiles SET status = 'active' WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $userId);

		return $stmt->execute();
	}
}
