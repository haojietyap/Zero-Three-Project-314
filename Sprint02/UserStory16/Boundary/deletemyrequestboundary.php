<?php
class deleteMyRequestBoundary {

    public function confirmDelete(int $requestID, array $requestSummary = []): void {
        echo "<h3>Confirm Delete</h3>";
        echo "<p>Are you sure you want to delete Request #$requestID?</p>";
        if (!empty($requestSummary)) {
            echo "<pre>" . print_r($requestSummary, true) . "</pre>";
        }
        echo "<form method='POST'>
                <input type='hidden' name='requestID' value='$requestID'>
                <button type='submit' name='confirm' value='yes'>Yes, Delete</button>
                <button type='submit' name='confirm' value='no'>Cancel</button>
              </form>";
    }

    public function getConfirmation(): bool {
        return isset($_POST['confirm']) && $_POST['confirm'] === 'yes';
    }

    public function showSuccess(int $requestID): void {
        echo "<p style='color: green;'>Request #$requestID deleted successfully.</p>";
        $this->refreshList();
    }

    public function showError(string $message): void {
        echo "<p style='color: red;'>$message</p>";
        $this->refreshList();
    }

    private function refreshList(): void {
        $requests = Request::all();
        echo "<h3>Current Requests:</h3><ul>";
        foreach ($requests as $id => $req) {
            echo "<li>Request #$id — " . htmlspecialchars($req['title']) .
                 " <a href='?delete=$id'>Delete</a></li>";
        }
        echo "</ul>";
    }
}
?>
