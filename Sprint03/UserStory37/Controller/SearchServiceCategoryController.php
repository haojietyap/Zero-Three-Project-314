<?php
require_once __DIR__ . '/Category.php';

class SearchCategoryController
{
    private $boundary;

    public function __construct($boundary)
    {
        $this->boundary = $boundary;
    }

    // Receive filters from boundary and return results array
    public function search(array $filters): array
    {
        return Category::findByFilters($filters);
    }
}
?>
