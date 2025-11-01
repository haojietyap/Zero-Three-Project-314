<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';
require_once __DIR__ . '/../../Boundaries/ServiceCategory/ViewServiceCategoryBoundary.php';

class ViewServiceCategoryController {
    private ServiceCategory $serviceCategory;
    private ViewServiceCategoryBoundary $boundary;

    public function __construct(
        ServiceCategory $serviceCategory = null,
        ViewServiceCategoryBoundary $boundary = null
    ) {
        $this->serviceCategory = $serviceCategory ?? new ServiceCategory();
        $this->boundary = $boundary ?? new ViewServiceCategoryBoundary();
    }

    public function showAllCategories(): void {
        $categories = $this->serviceCategory->getAllCategories();
        $this->viewCategoriesResult($categories);
    }

    public function viewCategoriesResult(array $categories): void {
        if (count($categories) > 0) {
            $this->boundary->renderList($categories);
        } else {
            $this->boundary->renderEmpty();
        }
    }

    public function getAllCategories(): array {
        return $this->serviceCategory->getAllCategories();
    }
}
?>
