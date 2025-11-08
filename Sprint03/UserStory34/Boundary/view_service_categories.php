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

class ViewServiceCategoryBoundary
{
    
    public function viewAllCategories(array $categories): void
    {
        // Highlight empty search
        if (empty($categories)) {
            echo "<p style='color: red; font-weight: bold;'>No service categories found.</p>";
            return;
        }

        // Table header
        echo '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-top: 20px;">';
        echo '<thead style="background-color: #f4f4f4;">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Description</th>';
        echo '<th>Status</th>';
        echo '<th>Created At</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through categories
        foreach ($categories as $cat) {
            $id = htmlspecialchars($cat['id']);
            $name = htmlspecialchars($cat['name']);
            $description = htmlspecialchars($cat['description']);
            $status = htmlspecialchars($cat['status'] ?? 'active');
            $createdAt = htmlspecialchars($cat['created_at']);

            echo '<tr>';
            echo "<td>{$id}</td>";
            echo "<td>{$name}</td>";
            echo "<td>{$description}</td>";
            echo "<td>{$status}</td>";
            echo "<td>{$createdAt}</td>";

            // Manager actions
            echo '<td>';
            echo "<a href='edit_service_category.php?id={$id}' style='color: #007bff;'>Edit</a> | ";
            echo "<a href='delete_service_category.php?id={$id}' style='color: red;' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
            echo '</td>';

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }
}
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
