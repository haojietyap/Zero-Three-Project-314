<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/SearchServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$searchServiceCategoryController = new SearchServiceCategoryController();

if (!isset($_GET['id'])) {
    echo "No category ID provided.";
    exit;
}

$categoryId = $_GET['id'];
$category = $searchServiceCategoryController->getCategoryById($categoryId);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'] ?? '';

    if (!empty($search)) {
        if ($searchServiceCategoryController->search($categoryId, $search)) {
            $message = "Here are your search results.";
            $category = $updateServiceCategoryController->getCategoryById($categoryId);
        } else {
            $message = "Error in getting search results.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
</head>
<body>

<div>
    <h1>Search</h1>

    <?php if ($message): ?>
        <div><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>


    <form method="POST">
        <label>Enter Your Search Here:</label>
        <input type="text" name="search" required>

        <button type="submit">Search</button>
    </form>

    <a href="view_service_categories.php">Back to Categories</a>
</div>

</body>
</html>

