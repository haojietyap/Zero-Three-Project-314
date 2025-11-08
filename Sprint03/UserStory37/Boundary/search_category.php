<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/SearchServiceCategoryController.php';

class SearchCategoryBoundary
{
    // Retrieve search filters from user input (e.g., keyword and status)
    public function getSearchFilters(): array
    {
        return [
            'keyword' => $_GET['keyword'] ?? '',
            'status'  => $_GET['status'] ?? 'active', // default to active
        ];
    }

    // Render search results
    public function renderResults(array $categories): void
    {
        if (empty($categories)) {
            $this->renderEmpty();
            return;
        }

        echo "<h2>Search Results</h2>";
        echo "<ul>";
        foreach ($categories as $category) {
            echo "<li>ID: {$category->getId()} | Name: {$category->getName()} 
                  | Description: {$category->getDescription()} 
                  | Status: {$category->getStatus()}</li>";
        }
        echo "</ul>";
    }

    // Render when no results found
    public function renderEmpty(): void
    {
        echo "<p>No categories found matching your search criteria.</p>";
    }

    // Render error messages
    public function renderError(string $message): void
    {
        echo "<p style='color:red;'>Error: {$message}</p>";
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

