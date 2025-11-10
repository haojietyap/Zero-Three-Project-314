<?php
session_start();

require_once __DIR__ . '/SearchServiceCategoryController.php';
require_once __DIR__ . '/ServiceCategory.php';

class SearchCategoryBoundary
{
    // Retrieve search filters from user input
    public function getSearchFilters(): array
    {
        return [
            'keyword' => $_GET['search'] ?? '',   
            'status'  => $_GET['status'] ?? 'active',
        ];
    }

    // Display search form and results
    public function display(array $categories = [], string $error = ''): void
    {
        echo "<h1>Search Service Categories</h1>";

        echo '<form method="GET">';
        echo '<input type="text" name="search" placeholder="Enter keyword" value="' . htmlspecialchars($_GET['search'] ?? '') . '">';
        echo '<button type="submit">Search</button>';
        echo '<a href="view_service_categories.php">Back</a>';
        echo '</form>';

        if ($error) {
            echo "<p style='color:red;'>$error</p>";
        } elseif (!empty($categories)) {
            echo "<ul>";
            foreach ($categories as $cat) {
                echo "<li>ID: {$cat->getId()} | Name: {$cat->getName()} | Description: {$cat->getDescription()} | Status: {$cat->isActive() ? 'Active' : 'Inactive'}</li>";
            }
            echo "</ul>";
        } elseif (isset($_GET['search'])) {
            echo "<p>No categories found.</p>";
        }
    }
}

// Instantiate boundary and controller
$boundary = new SearchCategoryBoundary();
$controller = new SearchCategoryController($boundary);

$filters = $boundary->getSearchFilters();
$categories = [];

$error = '';
if (!empty($filters['keyword'])) {
    $categories = $controller->search($filters);
} else if (isset($_GET['search'])) {
    $error = "Please enter a keyword to search.";
}

$boundary->display($categories, $error);
?>
