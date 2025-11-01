<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/ViewServiceCategoryController.php';
require_once __DIR__ . '/../../Controllers/Service Category/SearchServiceCategoryController.php';
require_once __DIR__ . '/../../Boundaries/ServiceCategory/ViewServiceCategoryBoundary.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$viewServiceCategoryController = new ViewServiceCategoryController();
$searchServiceCategoryController = new SearchServiceCategoryController(); 

$keyword = $_GET['search'] ?? '';
$categories = !empty($keyword)
    ? $searchServiceCategoryController->search($keyword)              
    : $viewServiceCategoryController->getAllCategories();

$boundary = new ViewServiceCategoryBoundary();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Service Categories</title>
</head>
<body>

    <h1>Service Categories</h1>
    <a href="../logout.php">Logout</a>

    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or description" value="<?= htmlspecialchars($keyword) ?>" />
        <button type="submit">Search</button>
        <a href="view_service_categories.php">Reset</a>
    </form>

<?php
$boundary->viewAllCategories($categories);
?>

<a href="manager_dashboard.php">Back to Dashboard</a>

</body>
</html>
