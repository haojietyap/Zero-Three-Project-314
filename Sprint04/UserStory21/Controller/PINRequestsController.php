<?php
require_once __DIR__ . '/../Entity/Request.php';

class viewPINRequestsController {

    public function showPINRequests(): void {
        // Optional default behavior (e.g., redirect to form)
    }

    public function listPINRequests(array $filters): array {
        if (empty($filters['PIN'])) {
            return [];
        }

        return Request::findByFilters($filters);
    }
}
?>