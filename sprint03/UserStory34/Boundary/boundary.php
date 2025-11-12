<?php
class ViewCategoriesBoundary {

    // Display all categories in a table
    public function viewAllCategories($categories = []) {
        echo "<h2>Volunteer Service Categories</h2>";

        echo "<form method='POST'>
                <button type='submit' name='refresh'>🔄 Refresh Categories</button>
              </form><br>";

        if (empty($categories)) {
            echo "<p style='color:red;'>No categories are currently available.</p>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Created At</th>
              </tr>";

        foreach ($categories as $category) {
            echo "<tr>
                    <td>{$category['category_id']}</td>
                    <td>{$category['category_name']}</td>
                    <td>{$category['description']}</td>
                    <td>{$category['created_at']}</td>
                  </tr>";
        }

        echo "</table>";
    }
}
?>
