<?php
require_once __DIR__ . '/../Entity/Request.php';

class CSRSearchRequestsController {

    public function search(array $filters): array {
        if (empty($filters['PIN'])) {
            return [];
        }

        return Request::findByFilters($filters);
    }
}
?>