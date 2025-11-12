<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class CSRSearchHistoryController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new CSRSearchHistoryBoundary();
        $this->entity = new CompletedService();
    }

    public function searchHistory($csrID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $filters = $this->boundary->getFilters();
            $requests = $this->entity->findByCsrAndFilters($csrID, $filters);
            $this->boundary->renderResults($requests, $filters);
        } else {
            $this->boundary->renderResults();
        }
    }
}
?>
