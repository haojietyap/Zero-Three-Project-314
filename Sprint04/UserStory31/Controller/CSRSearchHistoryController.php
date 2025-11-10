<?php
require_once __DIR__ . '/../Entity/Request.php';

class CSRSearchHistoryController {
    public function searchHistory(int $csrID, array $filters): array {
        return Request::findByCSRandFilters($csrID, $filters);
    }
}
?>

