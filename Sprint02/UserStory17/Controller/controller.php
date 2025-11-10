<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class SearchMyRequestsController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new SearchMyRequestsBoundary();
        $this->entity = new Request();
    }

    public function search($userID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $criteria = $this->boundary->getSearchInput();
            $results = $this->entity->searchByUser($userID, $criteria);
            $this->boundary->displaySearchForm($results, $criteria['keyword']);
        } else {
            $this->boundary->displaySearchForm();
        }
    }
}
?>
