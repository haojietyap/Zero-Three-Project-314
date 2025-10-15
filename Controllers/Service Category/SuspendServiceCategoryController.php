<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class SuspendServiceCategoryController {
    public function suspend($categoryId) {
        $serviceCategory = new ServiceCategory();
        return $serviceCategory->suspendCategory($categoryId);
    }
}
?>
