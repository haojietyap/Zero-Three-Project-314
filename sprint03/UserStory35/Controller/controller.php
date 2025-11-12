<?php
require_once __DIR__ . '/../Boundary/boundary.php';
require_once __DIR__ . '/../Entity/entity.php';

class UpdateCategoryController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new UpdateCategoryBoundary();
        $this->entity = new Category();
    }

    public function updateCategory() {
        // If no form submission, display category form (sample ID)
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Example: Load category with ID 1
            $category = $this->entity->getCategoryByID(1);
            $this->boundary->displayUpdateCategory($category);
            return;
        }

        // Get submitted data
        $formData = $this->boundary->getFormData();

        // Update the record
        $result = $this->entity->update($formData['category_id'], $formData);

        if (isset($result['errors'])) {
            $this->boundary->displayUpdateCategory($formData, $result['errors']);
        } else {
            $this->boundary->displaySuccess($result['category_id']);
        }
    }
}
?>
