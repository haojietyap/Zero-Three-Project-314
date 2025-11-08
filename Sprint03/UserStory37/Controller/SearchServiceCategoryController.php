<?php
require_once __DIR__ . '/../../Entities/Category.php';
require_once __DIR__ . '/../../Boundary/search_category.php';

class SearchCategoryController
{
    private SearchCategoryBoundary $boundary;

    public function __construct(SearchCategoryBoundary $boundary)
    {
        $this->boundary = $boundary;
    }

    public function search(): void
    {
        $filters = $this->boundary->getSearchFilters();

        if (empty($filters['keyword'])) {
            $this->boundary->renderError("Please enter a keyword to search.");
            return;
        }

        $categories = Category::findByFilters($filters);

        if (!empty($categories)) {
            $this->boundary->renderResults($categories);
        } else {
            $this->boundary->renderEmpty();
        }
    }
}
?>