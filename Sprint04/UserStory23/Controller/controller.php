<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class CSRShortlistSearchController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new CSRShortlistSearchBoundary();
        $this->entity = new Shortlist();
    }

    public function searchShortlist($csrID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $filters = $this->boundary->getFilters();
            $results = $this->entity->findByCsrAndFilters($csrID, $filters);
            $this->boundary->renderResults($results, $filters);
        } else {
            $this->boundary->renderResults();
        }
    }
}
?>
