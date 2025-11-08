<?php
require_once __DIR__ . '/../Entity/Shortlist.php';

class CSRShortlistController {
    public function listShortlist(int $csrID, array $filters = []): array {
        return Shortlist::findByCSR($csrID, $filters);
    }
}
?>

