<?php
// Controller/viewMyRequestsController.php

require_once __DIR__ . '/../Entity/Request.php';

class viewMyRequestsController {

    public function showMyRequests(int $userID): array {
        try {
            $requests = Request::findByUserID($userID);
            return $requests;
        } catch (Exception $e) {
            throw new Exception("Error retrieving requests: " . $e->getMessage());
        }
    }
}
?>
