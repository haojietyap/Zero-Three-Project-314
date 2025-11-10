<?php
class HistoricalMatchesBoundary {

    // Show the completed matches list
    public function viewHistoricalMatches($matches = []) {
        echo "<h2>Completed Match History</h2>";

        if (empty($matches)) {
            echo "<p style='color:red;'>No Records Found.</p>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Match ID</th>
                <th>Request Title</th>
                <th>Service Date</th>
                <th>Status</th>
                <th>Completed At</th>
              </tr>";

        foreach ($matches as $m) {
            echo "<tr>
                    <td>{$m['match_id']}</td>
                    <td>{$m['title']}</td>
                    <td>{$m['service_date']}</td>
                    <td>{$m['status']}</td>
                    <td>{$m['completed_at']}</td>
                  </tr>";
        }

        echo "</table>";
    }
}
?>
