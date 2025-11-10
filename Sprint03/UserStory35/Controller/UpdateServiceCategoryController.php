<?php
require_once __DIR__ . '/../../Entity/ServiceCategory.php';

class ViewCategoriesController
{
    private ServiceCategory $categoryEntity;

    public function __construct(ServiceCategory $categoryEntity = null)
    {
        $this->categoryEntity = $categoryEntity ?? new ServiceCategory();
    }

    // List all categories
    public function listAllCategories(): array
    {
        return $this->categoryEntity->listAllCategories();
    }

    // Search categories by keyword (name or description)
    public function searchCategories(string $keyword): array
    {
        return $this->categoryEntity->searchCategories($keyword);
    }
}
?>

