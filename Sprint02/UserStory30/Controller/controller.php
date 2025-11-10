<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class SearchHistoricalMatchesController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new SearchHistoricalMatchesBoundary();
        $this->entity = new Request();
    }

    public function search($userID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $filters = $this->boundary->getSearchFilters();
            $results = $this->entity->searchCompletedByUser($userID, $filters);
            $this->boundary->displaySearchForm($results, $filters);
        } else {
            $this->boundary->displaySearchForm();
        }
    }
}
?>
