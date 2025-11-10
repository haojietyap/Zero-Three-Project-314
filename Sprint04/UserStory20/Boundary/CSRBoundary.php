<?php
require_once '../Controller/CSRSearchRequestsController.php';
require_once '../Entity/Request.php';

class CSRSearchRequestsBoundary {
    public function run() {
        $controller = new CSRSearchRequestsController();
        $filters = $this->getSearchInput();
        $requests = $controller->search($filters);

        if (!empty($requests)) {
            $this->renderResults($requests);
        } else {
            $this->renderEmpty();
        }
    }

    private function getSearchInput(): array {
        return [
            'pin' => $_GET['PIN'] ?? null,
            'status' => $_GET['status'] ?? null
        ];
    }

    private function renderResults(array $requests): void {
        echo "<h2>Search Results</h2>";
        echo "<table border='1'><tr><th>ID</th><th>Title</th><th>Category</th><th>Status</th><th>Created At</th></tr>";
        foreach ($requests as $r) {
            echo "<tr>
                <td>{$r->id}</td>
                <td>{$r->title}</td>
                <td>{$r->category}</td>
                <td>{$r->status}</td>
                <td>{$r->createdAt->format('Y-m-d')}</td>
            </tr>";
        }
        echo "</table>";
    }

    private function renderEmpty(): void {
        echo "<p>No requests found for this PIN.</p>";
    }
}

// Run the boundary
$boundary = new CSRSearchRequestsBoundary();
$boundary->run();
?>

<!DOCTYPE html>
<html>
<body>
    <form method="get" action="">
        <label>Enter PIN:</label>
        <input type="text" name="PIN" required>
        <label>Status:</label>
        <select name="status">
            <option value="">All</option>
            <option value="open">Open</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
        <button type="submit">Search</button>
    </form>
</body>
</html>
