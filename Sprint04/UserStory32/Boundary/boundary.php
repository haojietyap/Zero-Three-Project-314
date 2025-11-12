<?php
class CSRViewHistoryBoundary {

    // Optional filters (if extended for date range or service type)
    public function getFilters() {
        return [
            'serviceType' => trim($_POST['serviceType'] ?? ''),
            'date' => trim($_POST['date'] ?? '')
        ];
    }

    // Renders the completed service history
    public function renderResults($requests = []) {
        echo "<h2>Completed Volunteer Service History</h2>";

        echo "<form method='POST'>
                <label>Filter by Service Type:</label><br>
                <input type='text' name='serviceType'><br><br>

                <label>Filter by Date:</label><br>
                <input type='date' name='date'><br><br>

                <button type='submit' name='filter'>Filter</button>
              </form><br>";

        if (empty($requests)) {
            $this->renderEmpty();
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Service ID</th>
                <th>Request ID</th>
                <th>CSR ID</th>
                <th>Service Type</th>
                <th>Duration (Minutes)</th>
                <th>Completed At</th>
              </tr>";

        foreach ($requests as $row) {
            echo "<tr>
                    <td>{$row['completed_service_id']}</td>
                    <td>{$row['request_id']}</td>
                    <td>{$row['csr_user_id']}</td>
                    <td>{$row['service_type']}</td>
                    <td>{$row['duration_minutes']}</td>
                    <td>{$row['completed_at']}</td>
                  </tr>";
        }
        echo "</table>";
    }

    // Displays message when no completed history is found
    public function renderEmpty() {
        echo "<p style='color:red;'>No completed volunteer services found.</p>";
    }
}
?>
