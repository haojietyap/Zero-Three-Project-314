<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class UpdateServiceCategoryController {
	
    public function getCategoryById($categoryId) {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->getCategoryById($categoryId);
    }

    public function update($categoryId, $name, $description) {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->updateCategory($categoryId, $name, $description);
    }
}
?>
