<?php
require_once __DIR__ . '/../../Entity/ServiceCategory.php';
require_once __DIR__ . '/../../Boundary/delete_category.php';

class DeleteCategoryController
{
    private DeleteCategoryBoundary $boundary;

    public function __construct(DeleteCategoryBoundary $boundary)
    {
        $this->boundary = $boundary;
    }

    public function confirm(int $categoryID): void
    {
        $category = Category::findById($categoryID);

        if (!$category) {
            $this->boundary->showError("Category not found.");
            return;
        }

        $this->boundary->displayConfirmation($categoryID, [
            'name' => $category->getName(),
            'description' => $category->getDescription(),
        ]);
    }

    public function delete(int $categoryID): bool
    {
        $category = Category::findById($categoryID);

        if (!$category) {
            $this->boundary->showError("Category not found.");
            return false;
        }

        // Check if user confirmed
        if (!$this->boundary->getConfirmation()) {
            $this->boundary->showError("Deletion was not confirmed.");
            return false;
        }

        // Attempt deletion
        if ($category->deleteById($categoryID)) {
            $this->boundary->showSuccess($categoryID);
            return true;
        } else {
            $this->boundary->showError("Failed to delete category.");
            return false;
        }
    }
}
?>

