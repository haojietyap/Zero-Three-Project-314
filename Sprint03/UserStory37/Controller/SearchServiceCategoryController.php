<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class SearchServiceCategoryController {
    public function search($keyword) {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->searchCategories($keyword);
    }
}
?>
