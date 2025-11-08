<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';
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

        $this->boundary->confirmDelete($categoryID, [
            'name' => $category->getName(),
            'description' => $category->getDescription(),
        ]);
    }

    public function delete(int $categoryID): void
    {
        $category = Category::findById($categoryID);

        if (!$category) {
            $this->boundary->showError("Category not found.");
            return;
        }

        if ($this->boundary->getConfirmation()) {
            if ($category->deleteById($categoryID)) {
                $this->boundary->showSuccess($categoryID);
            } else {
                $this->boundary->showError("Failed to delete category.");
            }
        } else {
            $this->boundary->showError("Deletion was not confirmed.");
        }
    }
}
?>
