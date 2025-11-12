<?php
class SearchCategoryBoundary {

    // Display the search interface
    public function displaySearchForm() {
        echo "<h2>Search Volunteer Service Categories</h2>
        <form method='POST'>
            <label>Enter Keyword:</label><br>
            <input type='text' name='keyword' placeholder='Search by name or description...' required>
            <button type='submit' name='search'>Search</button>
        </form>
        <hr>";
    }

    // Retrieve filter input from the Platform Manager
    public function getSearchFilters() {
        return [
            'keyword' => trim($_POST['keyword'] ?? '')
        ];
    }

    // Display search results
    public function displayResults($categories) {
        if (empty($categories)) {
            echo "<p style='color:red;'>No categories found matching your search criteria.</p>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Created At</th>
              </tr>";

        foreach ($categories as $c) {
            echo "<tr>
                    <td>{$c['category_id']}</td>
                    <td>{$c['category_name']}</td>
                    <td>{$c['description']}</td>
                    <td>{$c['created_at']}</td>
                  </tr>";
        }
        echo "</table>";
    }
}
?>
