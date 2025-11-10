<?php
require_once __DIR__ . '/../Controller/PINRequestsController.php';

class viewPINRequestsBoundary {

    public function run() {
        $controller = new viewPINRequestsController();
        $filters = $this->getFilters();
        $requests = $controller->listPINRequests($filters);

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>View Requests by PIN</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                form { margin-bottom: 20px; }
                table { border-collapse: collapse; width: 80%; }
                th, td { border: 1px solid #999; padding: 8px; text-align: left; }
                th { background-color: #f0f0f0; }
                .message { margin-top: 20px; font-style: italic; }
            </style>
        </head>
        <body>
            <h1>View Requests by PIN</h1>

            <!-- Search form -->
            <form method="get" action="">
                <label>Enter PIN:</label>
                <input type="text" name="PIN" required value="<?= htmlspecialchars($_GET['PIN'] ?? '') ?>">
                <label>Status:</label>
                <select name="status">
                    <option value="">All</option>
                    <option value="open" <?= (($_GET['status'] ?? '') === 'open') ? 'selected' : '' ?>>Open</option>
                    <option value="in_progress" <?= (($_GET['status'] ?? '') === 'in_progress') ? 'selected' : '' ?>>In Progress</option>
                    <option value="completed" <?= (($_GET['status'] ?? '') === 'completed') ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit">View</button>
            </form>

            <!-- Display results -->
            <?php
            if (!empty($requests)) {
                $this->renderList($requests);
            } elseif (!empty($_GET['PIN'])) {
                $this->renderEmpty();
            }
            ?>
        </body>
        </html>
        <?php
    }

    public function getFilters(): array {
        return [
            'PIN' => $_GET['PIN'] ?? null,
            'status' => $_GET['status'] ?? null
        ];
    }

    public function renderList(array $requests): void {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>";
        foreach ($requests as $req) {
            echo "<tr>
                    <td>" . htmlspecialchars($req->id) . "</td>
                    <td>" . htmlspecialchars($req->title) . "</td>
                    <td>" . htmlspecialchars($req->category) . "</td>
                    <td>" . htmlspecialchars($req->status) . "</td>
                    <td>" . htmlspecialchars($req->createdAt->format('Y-m-d')) . "</td>
                </tr>";
        }
        echo "</table>";
    }

    public function renderEmpty(): void {
        echo "<p class='message'>No requests found for this PIN.</p>";
    }
}

// Run
$boundary = new viewPINRequestsBoundary();
$boundary->run();
?>
