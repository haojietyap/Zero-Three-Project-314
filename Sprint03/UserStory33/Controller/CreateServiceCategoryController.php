<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class CreateServiceCategoryController {

    public function createCategory(array $data): array {
        $category = new ServiceCategory();
        $category->setName($data['name'] ?? '');
        $category->setDescription($data['description'] ?? '');

        // Validate data
        $errors = $category->validate();

        if (!empty($errors)) {
            // If name already exists, return exists
            foreach ($errors as $err) {
                if (strpos(strtolower($err), 'exists') !== false) {
                    return ['status' => 'exists', 'id' => null];
                }
            }
            return ['status' => 'error', 'id' => null];
        }

        // Save to DB
        $newId = $category->save();

        if ($newId > 0) {
            return ['status' => 'success', 'id' => $newId];
        } else {
            return ['status' => 'error', 'id' => null];
        }
    }
}
