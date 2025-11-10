<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';


class ViewMyRequestsController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new ViewMyRequestsBoundary();
        $this->entity = new Request();
    }

    public function showMyRequests($userID) {
        $requests = $this->entity->findByUserID($userID);
        $this->boundary->viewAllRequests($requests);
    }
}
?>
