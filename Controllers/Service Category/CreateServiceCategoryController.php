<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class CreateServiceCategoryController {
    public function createCategory($name, $description) {
        $serviceCategory = new ServiceCategory();

        if ($serviceCategory->existsByName($name)) {
            return 'exists';
        }

        return $serviceCategory->create($name, $description) ? 'success' : 'error';
    }
}
