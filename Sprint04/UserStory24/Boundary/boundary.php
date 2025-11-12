<?php
class CSRShortlistBoundary {

    // Render CSR shortlist in a table
    public function renderList($items = []) {
        echo "<h2>My Shortlisted Requests</h2>";

        if (empty($items)) {
            $this->renderEmpty();
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Shortlist ID</th>
                <th>Request ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Status</th>
                <th>Preferred Date</th>
                <th>Shortlisted At</th>
              </tr>";

        foreach ($items as $item) {
            echo "<tr>
                    <td>{$item['shortlist_id']}</td>
                    <td>{$item['request_id']}</td>
                    <td>{$item['title']}</td>
                    <td>{$item['description']}</td>
                    <td>{$item['location']}</td>
                    <td>{$item['status']}</td>
                    <td>{$item['preferred_date']}</td>
                    <td>{$item['shortlisted_at']}</td>
                  </tr>";
        }
        echo "</table>";
    }

    // Display message when no shortlist is found
    public function renderEmpty() {
        echo "<p style='color:red;'>No shortlisted requests found.</p>";
    }

    // Optional: retrieve filters (if CSR wants to filter shortlist)
    public function getFilters() {
        return [
            'status' => $_POST['status'] ?? '',
            'location' => trim($_POST['location'] ?? '')
        ];
    }
}
?>
