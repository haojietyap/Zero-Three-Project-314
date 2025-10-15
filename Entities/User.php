<?php
require_once __DIR__ . '/../Utilities/DB.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

   public function getByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

	public function createUser($name, $email, $password, $role) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return 'exists';
        }

        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, 'active')");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        return $stmt->execute() ? 'success' : 'error';
    }

    public function getAllUsers() {
        $result = $this->conn->query("SELECT * FROM users ORDER BY id ASC");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }
	
	public function getAllUsersProfile() { //Profiles 
        $result = $this->conn->query("SELECT * FROM users ORDER BY id ASC");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

	public function searchUsers($keyword) {
        $keyword = "%" . $keyword . "%";
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name LIKE ? OR email LIKE ? OR role LIKE ? ORDER BY id ASC");
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }
	
		public function searchUsersProfile($keyword) { //Profile 
        $keyword = "%" . $keyword . "%";
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name LIKE ? OR email LIKE ? OR role LIKE ? ORDER BY id ASC");
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users 
				WHERE id = '$id'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

	
	public function updateUser($id, $name, $email, $role) {
		$stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
		$stmt->bind_param("sssi", $name, $email, $password, $id);
    return $stmt->execute();
	}


    public function suspendUser($id) {
        $stmt = $this->conn->prepare("UPDATE users SET status = 'suspended' WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}
