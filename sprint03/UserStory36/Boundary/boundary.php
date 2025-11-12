<?php
class DeleteCategoryBoundary {

    // Display confirmation message
    public function displayConfirmation($categoryID) {
        echo "<h2>Delete Category Confirmation</h2>";
        echo "<p>Are you sure you want to delete category <strong>ID #$categoryID</strong>?</p>";
        echo "
        <form method='POST'>
            <input type='hidden' name='category_id' value='$categoryID'>
            <button type='submit' name='confirm' value='yes' style='background:red;color:white;'>Yes, Delete</button>
            <button type='submit' name='confirm' value='no'>Cancel</button>
        </form>
        ";
    }

    // Get confirmation response
    public function getConfirmation() {
        if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
            return true;
        }
        return false;
    }

    // Display result message
    public function showResult($success, $categoryID) {
        if ($success) {
            echo "<p style='color:green;'>✅ Category ID #$categoryID was successfully deleted.</p>";
        } else {
            echo "<p style='color:red;'>❌ Category deletion failed or was cancelled.</p>";
        }
        echo "<a href='view_categories.php'>← Back to Categories</a>";
    }
}
?>
