<?php
require_once __DIR__ . '/../Boundary/boundary.php';
require_once __DIR__ . '/../Entity/entity.php';

class SearchCategoryController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new SearchCategoryBoundary();
        $this->entity = new Category();
    }

    public function search() {
        // Step 1: Display search form
        $this->boundary->displaySearchForm();

        // Step 2: If search submitted, process the query
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $filters = $this->boundary->getSearchFilters();
            $categories = $this->entity->findByFilters($filters);
            $this->boundary->displayResults($categories);
        }
    }
}
?>
