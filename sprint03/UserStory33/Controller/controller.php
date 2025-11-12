<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class CreateCategoryController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new CreateCategoryBoundary();
        $this->entity = new Category();
    }

    public function createCategory() {
        // If form not submitted, display blank form
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->boundary->displayCreateCategory();
            return;
        }

        // Get form data
        $data = $this->boundary->getFormData();

        // Pass data to entity for processing
        $result = $this->entity->createCategory($data);

        // Handle results
        if (isset($result['errors'])) {
            $this->boundary->displayCreateCategory($result['errors']);
        } else {
            $this->boundary->displaySuccess($result['category_id']);
        }
    }
}
?>
