<?php
require_once __DIR__ . '/../Controller/CSRShortlistController.php';

class CSRShortlistBoundary {
    private CSRShortlistController $controller;
    private int $csrID;

    public function __construct() {
        $this->controller = new CSRShortlistController();
    }

    // Called when the "Save" button is clicked
    public function clickSave(int $requestID): void {
        // Assume CSR ID is coming from form input (e.g., $_POST)
        $this->csrID = (int)($_POST['csrID'] ?? 0);

        if ($this->csrID <= 0 || $requestID <= 0) {
            echo "<p style='color:red;'>Invalid CSR ID or Request ID.</p>";
            return;
        }

        $this->controller->addToShortlist($this->csrID, $requestID);
        echo "<p style='color:green;'>Request $requestID saved to CSR $this->csrID shortlist.</p>";
    }

    // Display shortlist for a specific CSR
    private function displayShortlist(int $csrID): void {
        $list = $this->controller->listShortlist($csrID);

        if (empty($list)) {
            echo "<p>No requests in the shortlist yet.</p>";
            return;
        }

        echo "<h3>CSR $csrID Shortlist:</h3>";
        echo "<ul>";
        foreach ($list as $item) {
            echo "<li>Request ID: " . htmlspecialchars($item['request_id']) .
                 " | Saved At: " . htmlspecialchars($item['saved_at']) . "</li>";
        }
        echo "</ul>";
    }

    // Main rendering method
    public function render(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save'])) {
                $this->clickSave((int)$_POST['requestID']);
            }

            if (isset($_POST['view'])) {
                $this->displayShortlist((int)$_POST['csrIDView']);
            }
        }

        // Render HTML forms
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>CSR Shortlist</title>
        </head>
        <body>
            <h2>Save Volunteer Request</h2>
            <form method="post">
                <label>CSR ID: <input type="number" name="csrID" required></label><br><br>
                <label>Request ID: <input type="number" name="requestID" required></label><br><br>
                <button type="submit" name="save">Save to Shortlist</button>
            </form>

            <hr>

            <h2>View Shortlist</h2>
            <form method="post">
                <label>CSR ID: <input type="number" name="csrIDView" required></label>
                <button type="submit" name="view">View Shortlist</button>
            </form>
        </body>
        </html>
        <?php
    }
}

// Run the boundary
$boundary = new CSRShortlistBoundary();
$boundary->render();
?>
