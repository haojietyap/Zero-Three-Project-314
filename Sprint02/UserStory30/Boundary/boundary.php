<?php
class SearchHistoricalMatchesBoundary {

    // Show search form and results
    public function displaySearchForm($results = [], $filters = []) {
        $keyword = htmlspecialchars($filters['keyword'] ?? '');
        $date = htmlspecialchars($filters['date'] ?? '');
        echo "<h2>Search Completed Matches</h2>";

        echo "<form method='POST'>
                <label>Keyword (Service or Request Title):</label><br>
                <input type='text' name='keyword' value='$keyword' placeholder='Enter keyword'><br><br>

                <label>Date (YYYY-MM-DD):</label><br>
                <input type='date' name='date' value='$date'><br><br>

                <button type='submit' name='search'>Search</button>
              </form><br>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($results)) {
                echo "<p style='color:red;'>No Records Found.</p>";
            } else {
                echo "<table border='1' cellpadding='8' cellspacing='0'>";
                echo "<tr>
                        <th>Match ID</th>
                        <th>Request Title</th>
                        <th>Service Date</th>
                        <th>Status</th>
                        <th>Completed At</th>
                      </tr>";

                foreach ($results as $row) {
                    echo "<tr>
                            <td>{$row['match_id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['service_date']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['completed_at']}</td>
                          </tr>";
                }
                echo "</table>";
            }
        }
    }

    // Collect user-entered filters
    public function getSearchFilters() {
        return [
            'keyword' => trim($_POST['keyword'] ?? ''),
            'date' => $_POST['date'] ?? ''
        ];
    }
}
?>
