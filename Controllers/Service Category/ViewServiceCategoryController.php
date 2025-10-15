<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class ViewServiceCategoryController {
    public function getAllCategories() {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->getAllCategories();
    }
	
	public function getCategoryById($id) {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->getCategoryById($id);
    }
}
?>
