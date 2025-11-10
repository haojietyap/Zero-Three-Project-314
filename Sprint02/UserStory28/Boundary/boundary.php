<?php
class RequestShortlistCountBoundary {

    // Display the input form and result
    public function displayShortlistCountForm($shortlistCount = null, $requestID = '') {
        echo "<h2>View Request Shortlist Count</h2>";

        echo "<form method='POST'>
                <label>Enter Request ID:</label><br>
                <input type='number' name='request_id' value='" . htmlspecialchars($requestID) . "' required>
                <button type='submit' name='submit'>View Shortlist Count</button>
              </form><br>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($shortlistCount === null) {
                echo "<p style='color:red;'>No request found with that ID.</p>";
            } else {
                echo "<p><strong>Request ID:</strong> $requestID<br>";
                echo "<strong>Number of Shortlists:</strong> $shortlistCount</p>";
            }
        }
    }

    // Get the entered Request ID
    public function getSelectedRequestID() {
        return intval($_POST['request_id'] ?? 0);
    }
}
?>
