<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/UpdateServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$updateServiceCategoryController = new UpdateServiceCategoryController();

if (!isset($_GET['id'])) {
    echo "No category ID provided.";
    exit;
}

$categoryId = $_GET['id'];
$category = $updateServiceCategoryController->getCategoryById($categoryId);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'] ?? '';
    $newDescription = $_POST['description'] ?? '';

    if (!empty($newName) && !empty($newDescription)) {
        if ($updateServiceCategoryController->update($categoryId, $newName, $newDescription)) {
            $message = "Category has been updated successfully.";
            $category = $updateServiceCategoryController->getCategoryById($categoryId);
        } else {
            $message = "Error. Failed to update category.";
        }
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

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>


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

