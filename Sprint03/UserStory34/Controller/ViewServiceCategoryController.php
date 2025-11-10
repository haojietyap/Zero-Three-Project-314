<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';
require_once __DIR__ . '/../../Boundary/view_service_categories.php';

class ViewCategoriesController
{
    private ServiceCategory $categoryEntity;
    private ViewCategoriesBoundary $boundary;

    public function __construct(
        ServiceCategory $categoryEntity = null,
        ViewCategoriesBoundary $boundary = null
    ) {
        $this->categoryEntity = $categoryEntity ?? new ServiceCategory();
        $this->boundary = $boundary ?? new ViewCategoriesBoundary();
    }

    public function listAllCategories(): array
    {
        return $this->categoryEntity->listAllCategories();
    }

    public function displayAllCategories(): void
    {
        $categories = $this->listAllCategories();
        $this->boundary->viewAllCategories($categories);
    }
}
?>
