<?php
require_once __DIR__ . '/../controller/CSRShortlistController.php';

class CSRShortlistBoundary {
    private $controller;

    public function __construct() {
        $this->controller = new CSRShortlistController();
    }

    // Called when "Save" form is submitted
    private function handleSave($csrID, $requestID) {
        $this->controller->addToShortlist($csrID, $requestID);
        echo "<p style='color:green;'>Request $requestID saved to CSR $csrID shortlist.</p>";
    }

    // Display shortlist
    private function displayShortlist($csrID) {
        $list = $this->controller->listShortlist($csrID);
        if (empty($list)) {
            echo "<p>No requests in the shortlist yet.</p>";
            return;
        }

        echo "<h3>CSR $csrID Shortlist:</h3>";
        echo "<ul>";
        foreach ($list as $item) {
            echo "<li>Request ID: " . $item['request_id'] . " | Saved At: " . $item['saved_at'] . "</li>";
        }
        echo "</ul>";
    }

    // Main HTML render and form handling
    public function render() {
        // Handle form submissions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['save'])) {
                $this->handleSave($_POST['csrID'], $_POST['requestID']);
            }

            if (isset($_POST['view'])) {
                $this->displayShortlist($_POST['csrIDView']);
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

// Instantiate and render
$boundary = new CSRShortlistBoundary();
$boundary->render();
?>

