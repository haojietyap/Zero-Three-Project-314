<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class DeleteServiceCategoryController {
    public function delete($categoryId) {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->deleteCategory($categoryId);
    }
}
?>
