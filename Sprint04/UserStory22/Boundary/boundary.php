<?php
class CSRShortlistBoundary {

    // Simulate CSR clicking save for a specific request
    public function clickSave($requestID) {
        echo "<p>Attempting to save Request ID <strong>$requestID</strong> to shortlist...</p>";
    }

    // Feedback message
    public function renderFeedback($message, $success = true) {
        $color = $success ? "green" : "red";
        echo "<p style='color:$color;'>$message</p>";
    }

    // Display all shortlisted requests
    public function renderShortlist($shortlist) {
        echo "<h2>My Shortlisted Requests</h2>";

        if (empty($shortlist)) {
            echo "<p style='color:red;'>No shortlisted requests found.</p>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>Shortlist ID</th><th>Request ID</th><th>Saved At</th></tr>";

        foreach ($shortlist as $item) {
            echo "<tr>
                    <td>{$item['shortlist_id']}</td>
                    <td>{$item['request_id']}</td>
                    <td>{$item['shortlisted_at']}</td>
                  </tr>";
        }
        echo "</table>";
    }
}
?>
