<?php
require_once __DIR__ . '/../../Entity/ServiceCategory.php';

class CreateServiceCategoryController
{
    public function createCategory(array $data): array
    {
        $category = new ServiceCategory();
        return $category->createCategory($data);
    }
}
?>
