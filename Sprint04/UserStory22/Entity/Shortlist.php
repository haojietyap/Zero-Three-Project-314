<?php
require_once __DIR__ . '/../database.php';

class Shortlist {
    private $csrID;
    private $requestID;
    private $savedAt;

    public function __construct($csrID, $requestID) {
        $this->csrID = $csrID;
        $this->requestID = $requestID;
        $this->savedAt = date('Y-m-d H:i:s');
    }

    public function save() {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO shortlist (csr_id, request_id, saved_at) VALUES (?, ?, ?)");
        $stmt->execute([$this->csrID, $this->requestID, $this->savedAt]);
    }

    public static function findByCSR($csrID) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM shortlist WHERE csr_id = ?");
        $stmt->execute([$csrID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>