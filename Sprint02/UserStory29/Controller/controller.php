<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class HistoricalMatchesController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new HistoricalMatchesBoundary();
        $this->entity = new Request();
    }

    public function showHistory($userID) {
        $matches = $this->entity->findCompletedByUser($userID);
        $this->boundary->viewHistoricalMatches($matches);
    }
}
?>
