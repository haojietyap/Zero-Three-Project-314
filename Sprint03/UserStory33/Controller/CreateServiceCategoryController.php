<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class CreateServiceCategoryController
{
    public function createCategory(array $data): array
    {
        $category = new ServiceCategory();
        $category->setName(trim($data['name'] ?? ''));
        $category->setDescription(trim($data['description'] ?? ''));

        // Validate the entity
        $errors = $category->validate();

        if (!empty($errors)) {
            foreach ($errors as $err) {
                if (stripos($err, 'exists') !== false) {
                    return [
                        'status' => 'exists',
                        'id' => null
                    ];
                }
            }

            return [
                'status' => 'error',
                'id' => null,
                'errors' => $errors
            ];
        }

        $newId = $category->save();

        if ($newId && $newId > 0) {
            return [
                'status' => 'success',
                'id' => $newId
            ];
        }

        return [
            'status' => 'error',
            'id' => null
        ];
    }
}
