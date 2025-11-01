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

}
