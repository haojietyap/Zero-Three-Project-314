<?php
class DeleteMyRequestBoundary {

    // Ask for confirmation before deleting
    public function displayConfirmation($requestID) {
        echo "<h2>Confirm Delete Request</h2>";
        echo "<p>Are you sure you want to delete this request (ID: $requestID)?</p>";
        echo "<form method='POST'>
                <input type='hidden' name='request_id' value='$requestID'>
                <button type='submit' name='confirm' value='yes'>Yes, Delete</button>
                <button type='submit' name='confirm' value='no'>Cancel</button>
              </form>";
    }

    // Retrieve user confirmation choice
    public function getConfirmation() {
        return $_POST['confirm'] ?? null;
    }
}
?>
