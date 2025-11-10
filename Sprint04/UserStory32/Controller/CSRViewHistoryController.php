<?php
require_once __DIR__ . '/../Entity/Request.php';

class CSRViewHistoryController {
    public function listCompletedRequest(int $csrID, array $filters): array {
        return Request::searchByCSR($csrID, $filters);
    }
}
?>

