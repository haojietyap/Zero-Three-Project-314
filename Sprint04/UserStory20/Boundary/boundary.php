<?php
class SearchPINRequestsBoundary {

    // Display search form and results
    public function displaySearchForm($results = [], $filters = []) {
        $keyword = htmlspecialchars($filters['keyword'] ?? '');
        $category = htmlspecialchars($filters['category'] ?? '');
        $status = htmlspecialchars($filters['status'] ?? '');
        $location = htmlspecialchars($filters['location'] ?? '');
        $date = htmlspecialchars($filters['date'] ?? '');

        echo "<h2>Search Requests Created by PIN</h2>";

        echo "<form method='POST'>
                <label>Keyword (Title or Description):</label><br>
                <input type='text' name='keyword' value='$keyword'><br><br>

                <label>Category ID:</label><br>
                <input type='number' name='category' value='$category'><br><br>

                <label>Status:</label><br>
                <select name='status'>
                    <option value=''>-- Any --</option>
                    <option value='OPEN' " . ($status === 'OPEN' ? 'selected' : '') . ">OPEN</option>
                    <option value='CONFIRMED' " . ($status === 'CONFIRMED' ? 'selected' : '') . ">CONFIRMED</option>
                    <option value='COMPLETED' " . ($status === 'COMPLETED' ? 'selected' : '') . ">COMPLETED</option>
                    <option value='CANCELLED' " . ($status === 'CANCELLED' ? 'selected' : '') . ">CANCELLED</option>
                </select><br><br>

                <label>Location:</label><br>
                <input type='text' name='location' value='$location'><br><br>

                <label>Date (Preferred):</label><br>
                <input type='date' name='date' value='$date'><br><br>

                <button type='submit' name='search'>Search</button>
              </form><br>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($results)) {
                echo "<p style='color:red;'>No matching requests found.</p>";
            } else {
                echo "<table border='1' cellpadding='8' cellspacing='0'>";
                echo "<tr>
                        <th>Request ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Preferred Date</th>
                        <th>Status</th>
                      </tr>";
                foreach ($results as $row) {
                    echo "<tr>
                            <td>{$row['request_id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['category_name']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['preferred_date']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
                echo "</table>";
            }
        }
    }

    // Get filters from CSR input
    public function getSearchInput() {
        return [
            'keyword' => trim($_POST['keyword'] ?? ''),
            'category' => $_POST['category'] ?? '',
            'status' => $_POST['status'] ?? '',
            'location' => trim($_POST['location'] ?? ''),
            'date' => $_POST['date'] ?? ''
        ];
    }
}
?>
