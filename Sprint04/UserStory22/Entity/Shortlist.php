<?php
require_once __DIR__ . '/../database.php';

class Shortlist {
    public int $csr_user_id;
    public int $request_id;
    public DateTime $shortlisted_at;

    public function __construct(int $csr_user_id, int $request_id) {
        $this->csr_user_id = $csr_user_id;
        $this->request_id = $request_id;
        $this->shortlisted_at = new DateTime(); // current timestamp
    }

    // Save to database
    public function save(): void {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare(
            "INSERT INTO request_shortlists (csr_user_id, request_id, shortlisted_at)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $this->csr_user_id,
            $this->request_id,
            $this->shortlisted_at->format('Y-m-d H:i:s')
        ]);
    }

    // Retrieve shortlist for a CSR
    public static function findByCSR(int $csr_user_id): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM request_shortlists WHERE csr_user_id = ?");
        $stmt->execute([$csr_user_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $shortlist = [];
        foreach ($rows as $row) {
            $item = new Shortlist((int)$row['csr_user_id'], (int)$row['request_id']);
            $item->shortlisted_at = new DateTime($row['shortlisted_at']);
            $shortlist[] = $item;
        }

        return $shortlist;
    }
}
?>
