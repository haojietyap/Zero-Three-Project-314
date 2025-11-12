<?php
class CSRSearchHistoryBoundary {

    // Retrieve search filters from CSR input
    public function getFilters() {
        return [
            'keyword' => trim($_POST['keyword'] ?? ''),
            'serviceType' => trim($_POST['serviceType'] ?? ''),
            'date' => trim($_POST['date'] ?? '')
        ];
    }

    // Display results in a table
    public function renderResults($requests = [], $filters = []) {
        $keyword = htmlspecialchars($filters['keyword'] ?? '');
        $serviceType = htmlspecialchars($filters['serviceType'] ?? '');
        $date = htmlspecialchars($filters['date'] ?? '');

        echo "<h2>Search Completed Volunteer Service History</h2>";

        echo "<form method='POST'>
                <label>Keyword (Title / Description):</label><br>
                <input type='text' name='keyword' value='$keyword'><br><br>

                <label>Service Type:</label><br>
                <input type='text' name='serviceType' value='$serviceType'><br><br>

                <label>Date (Completed):</label><br>
                <input type='date' name='date' value='$date'><br><br>

                <button type='submit' name='search'>Search</button>
              </form><br>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($requests)) {
                $this->renderEmpty();
            } else {
                echo "<table border='1' cellpadding='8' cellspacing='0'>";
                echo "<tr>
                        <th>Service ID</th>
                        <th>Request ID</th>
                        <th>CSR ID</th>
                        <th>Service Type</th>
                        <th>Duration (Minutes)</th>
                        <th>Completed At</th>
                      </tr>";

                foreach ($requests as $r) {
                    echo "<tr>
                            <td>{$r['completed_service_id']}</td>
                            <td>{$r['request_id']}</td>
                            <td>{$r['csr_user_id']}</td>
                            <td>{$r['service_type']}</td>
                            <td>{$r['duration_minutes']}</td>
                            <td>{$r['completed_at']}</td>
                          </tr>";
                }
                echo "</table>";
            }
        }
    }

    // If no results found
    public function renderEmpty() {
        echo "<p style='color:red;'>No completed volunteer services found matching the criteria.</p>";
    }
}
?>
