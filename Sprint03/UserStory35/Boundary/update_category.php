<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/UpdateServiceCategoryController.php';

class UpdateCategoryBoundary
{
    public function showEditForm(int $categoryID, array $categoryData, array $errors = [], array $old = []): void
    {
        // Merge old data (if form was submitted with errors)
        $data = !empty($old) ? array_merge($categoryData, $old) : $categoryData;

        include __DIR__ . '/views/edit_category_form.php';
    }

    public function getFormData(): array
    {
        // Typically retrieved from POST
        return [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
        ];
    }

    public function showSuccess(int $categoryID): void
    {
        echo "<p>Category #{$categoryID} updated successfully!</p>";
    }

    public function showError(string $message): void
    {
        echo "<p style='color:red;'>Error: {$message}</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Service Category</title>
</head>
<body>

<div>
    <h2>Update Category</h2>

    <form method="POST">
        <label>New Name:</label>
        <input type="text" name="name" required>

        <label>New Description:</label>
        <input type="text" name="description" required>

        <button type="submit">Save Changes</button>
    </form>

    <a href="view_service_categories.php">Back to Categories</a>
</div>

</body>
</html>

