<?php
class RequestViewCountBoundary {

    // Display form to select request ID and show the view count
    public function displayViewCountForm($viewCount = null, $requestID = '') {
        echo "<h2>View Request View Count</h2>";

        echo "<form method='POST'>
                <label>Enter Request ID:</label><br>
                <input type='number' name='request_id' value='" . htmlspecialchars($requestID) . "' required>
                <button type='submit' name='submit'>View Count</button>
              </form><br>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($viewCount === null) {
                echo "<p style='color:red;'>No request found with that ID.</p>";
            } else {
                echo "<p><strong>Request ID:</strong> $requestID<br>";
                echo "<strong>Number of Views:</strong> $viewCount</p>";
            }
        }
    }

    // Get request ID entered by the PIN
    public function getSelectedRequestID() {
        return intval($_POST['request_id'] ?? 0);
    }
}
?>
