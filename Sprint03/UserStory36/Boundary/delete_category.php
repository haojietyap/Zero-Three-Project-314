<?php
session_start();
require_once __DIR__ . '/../../Controller/DeleteServiceCategoryController.php';

class DeleteCategoryBoundary
{
    public function displayConfirmation(int $categoryID, array $categorySummary = []): void
    {
        echo "<h2>Confirm Delete</h2>";
        echo "<p>Are you sure you want to delete the category 
              <strong>" . htmlspecialchars($categorySummary['name']) . "</strong>?</p>";

        echo "<form method='POST'>
                <input type='hidden' name='confirm' value='1'>
                <button type='submit'>Yes, Delete</button>
                <a href='view_service_categories.php'>Cancel</a>
              </form>";
    }

    public function getConfirmation(): bool
    {
        return isset($_POST['confirm']) && $_POST['confirm'] === '1';
    }

    public function showSuccess(int $categoryID): void
    {
        echo "<p style='color:green;'>Category #{$categoryID} deleted successfully!</p>";
    }

    public function showError(string $message): void
    {
        echo "<p style='color:red;'>Error: {$message}</p>";
    }
}
?>
