<?php
require_once __DIR__ . '/../Boundary/boundary.php';
require_once __DIR__ . '/../Entity/entity.php';

class DeleteCategoryController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new DeleteCategoryBoundary();
        $this->entity = new Category();
    }

    public function delete($categoryID) {
        // Step 1: Display confirmation prompt if no confirmation yet
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->boundary->displayConfirmation($categoryID);
            return;
        }

        // Step 2: Check manager response
        $confirmed = $this->boundary->getConfirmation();

        if ($confirmed) {
            $success = $this->entity->deleteByID($categoryID);
            $this->boundary->showResult($success, $categoryID);
        } else {
            $this->boundary->showResult(false, $categoryID);
        }
    }
}
?>
