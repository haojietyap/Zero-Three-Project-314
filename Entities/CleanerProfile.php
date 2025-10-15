<?php
require_once __DIR__ . '/../Utilities/DB.php';

class CleanerProfile {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }
	
	public function exists($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM cleaner_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}
	
	public function getProfileByUserId($userId) {
		$stmt = $this->conn->prepare("SELECT * FROM cleaner_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}

    public function createProfile($userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, 
								  $languagePreference, $expertise, $rating) {
		$stmt = $this->conn->prepare("SELECT * FROM cleaner_profiles WHERE user_id = ?");
		$stmt->bind_param("i", $userId);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
        return 'exists';
    }

    $stmt = $this->conn->prepare("INSERT INTO cleaner_profiles 
        (user_id, phone, address, experience, preferred_cleaning_time, cleaning_frequency, language_preference, expertise, rating, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
		$stmt->bind_param("isssssssd", $userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $expertise, $rating);
		return $stmt->execute() ? 'success' : 'error';
	}


    public function getCleanerProfileByUserId($userId) {
        $sql = "SELECT cp.*, sc.name AS category_name 
                FROM cleaner_profiles cp 
                LEFT JOIN service_categories sc 
                ON cp.expertise = sc.category_id
                WHERE cp.user_id = '$userId'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }
	
	public function updateCleanerProfile($userId, $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, 
					$languagePreference, $expertise, $rating) {
		$sql = "UPDATE cleaner_profiles SET 
                phone = ?, 
                address = ?, 
                experience = ?, 
                preferred_cleaning_time = ?, 
                cleaning_frequency = ?, 
                language_preference = ?, 
                expertise = ?, 
                rating = ?
				WHERE user_id = ?";

		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sssssssdi", $phone, $address, $experience, $preferredCleaningTime, $cleaningFrequency, $languagePreference, $expertise, $rating, $userId);
    
		return $stmt->execute();
	}

	public function suspendProfile($userId) {
		$sql = "UPDATE cleaner_profiles SET status = 'suspended' WHERE user_id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $userId);

		return $stmt->execute();
	}
 	
	public function getAllActiveCleaners() {
		$sql = "SELECT cp.*, u.name, u.email, sc.name AS category_name
				FROM cleaner_profiles cp
				JOIN users u ON cp.user_id = u.id
				LEFT JOIN service_categories sc ON cp.expertise = sc.category_id
				WHERE cp.status = 'active' AND u.status = 'active'";
    
		$result = mysqli_query($this->conn, $sql);

		$cleaners = [];
			while ($row = mysqli_fetch_assoc($result)) {
			$cleaners[] = $row;
		}

		return $cleaners;
	}

	public function searchCleanersByCategoryOrRating($keyword) { //Homeowner
    $sql = "SELECT cp.*, u.name, sc.name AS category_name
            FROM cleaner_profiles cp
            JOIN users u ON cp.user_id = u.id
            LEFT JOIN service_categories sc ON cp.expertise = sc.category_id
            WHERE cp.status = 'active'
            AND (
                sc.name LIKE '%$keyword%' 
				OR cp.address LIKE '%$keyword%'
                OR cp.rating LIKE '%$keyword%'
            )";

    $result = mysqli_query($this->conn, $sql);
    $cleaners = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cleaners[] = $row;
    }
    return $cleaners;
}

	
}
?>
