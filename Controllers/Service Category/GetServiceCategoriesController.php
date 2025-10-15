<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class GetServiceCategoriesController {
    public function getAll() {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->getAllCategories();
    }
}
