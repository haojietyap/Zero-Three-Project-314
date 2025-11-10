<?php
class SearchMyRequestsBoundary {

    // Display search form and results
    public function displaySearchForm($results = [], $keyword = '') {
        echo "<h2>Search My Requests</h2>";

        echo "<form method='POST'>
                <input type='text' name='keyword' placeholder='Enter keyword or request title' 
                       value='" . htmlspecialchars($keyword) . "' required>
                <button type='submit' name='search'>Search</button>
              </form><br>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($results)) {
                echo "<p style='color:red;'>No matching requests found.</p>";
            } else {
                echo "<table border='1' cellpadding='8' cellspacing='0'>";
                echo "<tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Preferred Date</th>
                        <th>Status</th>
                      </tr>";

                foreach ($results as $r) {
                    echo "<tr>
                            <td>{$r['request_id']}</td>
                            <td>{$r['category_name']}</td>
                            <td>{$r['title']}</td>
                            <td>{$r['description']}</td>
                            <td>{$r['location']}</td>
                            <td>{$r['preferred_date']}</td>
                            <td>{$r['status']}</td>
                          </tr>";
                }
                echo "</table>";
            }
        }
    }

    // Get keyword input from user
    public function getSearchInput() {
        return [
            'keyword' => trim($_POST['keyword'] ?? '')
        ];
    }
}
?>
