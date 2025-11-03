<?php
require_once __DIR__ . '/../Entity/Request.php';

class searchMyRequestsController {
    public function search(int $userID, array $criteria): array {
        return Request::searchByUser($userID, $criteria);
    }
}
