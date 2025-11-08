<?php
require_once __DIR__ . '/../../Entities/ServiceCategory.php';

class CategoryRepository
{
    public function findById(int $id): ?Category
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Category(
            (int)$row['id'],
            $row['name'],
            $row['description'],
            new DateTimeImmutable($row['updated_at'])
        );
    }
}

class UpdateCategoryController
{
    private UpdateCategoryBoundary $boundary;
    private CategoryRepository $repository;

    public function __construct(UpdateCategoryBoundary $boundary, CategoryRepository $repository)
    {
        $this->boundary = $boundary;
        $this->repository = $repository;
    }

    public function editForm(int $categoryID)
    {
        $category = $this->repository->findById($categoryID);

        if (!$category) {
            $this->boundary->showError("Category not found.");
            return;
        }

        $this->boundary->showEditForm($categoryID, [
            'name' => $category->getName(),
            'description' => $category->getDescription(),
        ]);
    }

    public function update(int $categoryID, array $data)
    {
        $category = $this->repository->findById($categoryID);

        if (!$category) {
            $this->boundary->showError("Category not found.");
            return;
        }

        $category->applyUpdates($data);
        $errors = $category->validateUpdate();

        if (!empty($errors)) {
            $this->boundary->showEditForm($categoryID, [
                'name' => $category->getName(),
                'description' => $category->getDescription(),
            ], $errors, $data);
            return;
        }

        if ($category->save()) {
            $this->boundary->showSuccess($categoryID);
        } else {
            $this->boundary->showError("Failed to update category.");
        }
    }
}

?>
