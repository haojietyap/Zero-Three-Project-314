<?php
require_once __DIR__ . '/../Utilities/DB.php';

class PINProfile {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }
	
	public function exists($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM PIN_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}

	public function create($userId, $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference) {
		$stmt = $this->conn->prepare("INSERT INTO PIN_profiles (user_id, phone, address, preferred_consultation_time, consultation_frequency, language_preference, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
		$stmt->bind_param("isssss", $userId, $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference);
		return $stmt->execute();
	}


	public function hasPINProfile($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM PIN_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}


    public function getProfileByUserId($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM PIN_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}
	
	public function updateProfile($userId, $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference) {
		$stmt = $this->conn->prepare("UPDATE PIN_profiles 
									SET phone = ?, address = ?, preferred_consultation_time = ?, consultation_frequency = ?, language_preference = ? 
									WHERE user_id = ?");
									
		$stmt->bind_param("sssssi", $phone, $address, $preferredConsultationTime, $consultationFrequency, $languagePreference, $userId);
		return $stmt->execute();
	}

	public function suspendProfile($userId) {
		$sql = "UPDATE PIN_profiles SET status = 'suspended' WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $userId);

		return $stmt->execute();
	}
	
	public function unsuspendProfile($userId) {
		$sql = "UPDATE PIN_profiles SET status = 'active' WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $userId);

		return $stmt->execute();
	}
}

