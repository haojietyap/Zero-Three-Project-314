<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class CSRViewHistoryController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new CSRViewHistoryBoundary();
        $this->entity = new CompletedService();
    }

    public function listCompletedRequest($csrID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter'])) {
            $filters = $this->boundary->getFilters();
            $results = $this->entity->searchByCsr($csrID, $filters);
            $this->boundary->renderResults($results);
        } else {
            $results = $this->entity->searchByCsr($csrID);
            $this->boundary->renderResults($results);
        }
    }
}
?>
