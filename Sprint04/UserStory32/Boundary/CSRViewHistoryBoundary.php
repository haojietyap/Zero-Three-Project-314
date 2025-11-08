<?php
require_once __DIR__ . '/../Controller/CSRViewHistoryController.php';

class CSRViewHistoryBoundary {
    private CSRViewHistoryController $controller;

    public function __construct() {
        $this->controller = new CSRViewHistoryController();
    }

    public function getFilters(): array {
        return [
            'serviceType' => $_GET['serviceType'] ?? '',
            'startDate' => $_GET['startDate'] ?? '',
            'endDate' => $_GET['endDate'] ?? ''
        ];
    }

    public function renderResults(array $requests): void {
        echo "<h2>Completed Volunteer Services</h2>";
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Service Type</th>
                <th>Completed At</th>
                <th>Duration (min)</th>
              </tr>";

        foreach ($requests as $req) {
            echo "<tr>";
            echo "<td>{$req['id']}</td>";
            echo "<td>{$req['userID']}</td>";
            echo "<td>" . htmlspecialchars($req['serviceType']) . "</td>";
            echo "<td>" . htmlspecialchars(date('Y-m-d', strtotime($req['completedAt']))) . "</td>";
            echo "<td>{$req['durationMinutes']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    public function renderEmpty(): void {
        echo "<p><em>No completed volunteer services found for the selected filters.</em></p>";
    }

    public function handleRequest(int $csrID): void {
        $filters = $this->getFilters();
        $results = $this->controller->listCompletedRequest($csrID, $filters);

        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <title>CSR Volunteer Service History</title>
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
            <h1>CSR Volunteer Service History</h1>

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

        if (!empty($results)) {
            $this->renderResults($results);
        } else {
            $this->renderEmpty();
        }

        echo "</body></html>";
    }
}

// Run Boundary directly (example CSR ID = 12)
$boundary = new CSRViewHistoryBoundary();
$boundary->handleRequest(12);
?>

