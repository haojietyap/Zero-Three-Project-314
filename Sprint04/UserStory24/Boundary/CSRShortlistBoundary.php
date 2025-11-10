<?php
require_once __DIR__ . '/../Controller/CSRShortlistController.php';

class CSRShortlistBoundary {
    private CSRShortlistController $controller;

    public function __construct() {
        $this->controller = new CSRShortlistController();
    }

    public function getFilters(): array {
        return [
            'serviceType' => $_GET['serviceType'] ?? '',
            'startDate' => $_GET['startDate'] ?? '',
            'endDate' => $_GET['endDate'] ?? ''
        ];
    }

    public function renderList(array $items): void {
        echo "<h2>Shortlisted Requests</h2>";
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>Request ID</th>
                <th>User ID</th>
                <th>Service Type</th>
                <th>Completed At</th>
                <th>Duration (min)</th>
                <th>Saved At</th>
              </tr>";

        foreach ($items as $item) {
            echo "<tr>";
            echo "<td>{$item['requestID']}</td>";
            echo "<td>{$item['userID']}</td>";
            echo "<td>" . htmlspecialchars($item['serviceType']) . "</td>";
            echo "<td>" . htmlspecialchars(date('Y-m-d', strtotime($item['completedAt']))) . "</td>";
            echo "<td>{$item['durationMinutes']}</td>";
            echo "<td>" . htmlspecialchars(date('Y-m-d', strtotime($item['savedAt']))) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    public function renderEmpty(): void {
        echo "<p><em>No shortlisted requests found.</em></p>";
    }

    public function handleRequest(int $csrID): void {
        $filters = $this->getFilters();
        $items = $this->controller->listShortlist($csrID, $filters);

        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>CSR Shortlisted Requests</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                form { margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; }
                th { background-color: #f2f2f2; }
                tr:nth-child(even) { background-color: #fafafa; }
            </style>
        </head>
        <body>
            <h1>CSR Shortlisted Requests</h1>

            <form method='GET'>
                <label>Service Type:
                    <input type='text' name='serviceType' value='" . htmlspecialchars($filters['serviceType']) . "'>
                </label>
                <label>Start Date:
                    <input type='date' name='startDate' value='" . htmlspecialchars($filters['startDate']) . "'>
                </label>
                <label>End Date:
                    <input type='date' name='endDate' value='" . htmlspecialchars($filters['endDate']) . "'>
                </label>
                <button type='submit'>Filter</button>
            </form>";

        if (!empty($items)) {
            $this->renderList($items);
        } else {
            $this->renderEmpty();
        }

        echo "</body></html>";
    }
}

// Run boundary 
$boundary = new CSRShortlistBoundary();
$boundary->handleRequest();
?>

