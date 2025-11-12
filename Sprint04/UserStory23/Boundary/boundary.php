<?php
class CSRShortlistSearchBoundary {

    // Get CSR search/filter inputs
    public function getFilters() {
        return [
            'keyword'  => trim($_POST['keyword'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'status'   => trim($_POST['status'] ?? ''),
            'date'     => trim($_POST['date'] ?? '')
        ];
    }

    // Render search form and results
    public function renderResults($items = [], $filters = []) {
        $keyword  = htmlspecialchars($filters['keyword'] ?? '');
        $location = htmlspecialchars($filters['location'] ?? '');
        $status   = htmlspecialchars($filters['status'] ?? '');
        $date     = htmlspecialchars($filters['date'] ?? '');

        echo "<h2>Search My Shortlisted Requests</h2>";

        echo "<form method='POST'>
                <label>Keyword (Title or Description):</label><br>
                <input type='text' name='keyword' value='$keyword'><br><br>

                <label>Location:</label><br>
                <input type='text' name='location' value='$location'><br><br>

                <label>Status:</label><br>
                <select name='status'>
                    <option value=''>-- Any --</option>
                    <option value='OPEN' " . ($status === 'OPEN' ? 'selected' : '') . ">OPEN</option>
                    <option value='CONFIRMED' " . ($status === 'CONFIRMED' ? 'selected' : '') . ">CONFIRMED</option>
                    <option value='COMPLETED' " . ($status === 'COMPLETED' ? 'selected' : '') . ">COMPLETED</option>
                    <option value='CANCELLED' " . ($status === 'CANCELLED' ? 'selected' : '') . ">CANCELLED</option>
                </select><br><br>

                <label>Preferred Date:</label><br>
                <input type='date' name='date' value='$date'><br><br>

                <button type='submit' name='search'>Search</button>
              </form><br>";

        // Display results after search
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($items)) {
                $this->renderEmpty();
            } else {
                echo "<table border='1' cellpadding='8' cellspacing='0'>";
                echo "<tr>
                        <th>Shortlist ID</th>
                        <th>Request ID</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Preferred Date</th>
                        <th>Shortlisted At</th>
                      </tr>";

                foreach ($items as $row) {
                    echo "<tr>
                            <td>{$row['shortlist_id']}</td>
                            <td>{$row['request_id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['preferred_date']}</td>
                            <td>{$row['shortlisted_at']}</td>
                          </tr>";
                }
                echo "</table>";
            }
        }
    }

    // Message for no results
    public function renderEmpty() {
        echo "<p style='color:red;'>No shortlisted requests found matching the criteria.</p>";
    }
}
?>
