<?php
require_once __DIR__ . '/../Entity/WeeklyReport.php';
require_once __DIR__ . '/../Controller/WeeklyReportController.php';

class GenerateWeeklyReportBoundary
{
    private string $startDate;
    private string $endDate;

    public function __construct()
    {
        $this->startDate = $_GET['startDate'] ?? date('Y-m-d'); // default today
        $this->endDate   = $_GET['endDate'] ?? date('Y-m-d');   // default today
    }

    public function getSelectedWeek(): array
    {
        return [
            'startDate' => $this->startDate,
            'endDate'   => $this->endDate
        ];
    }

    public function displayGenerateReport(int $totalRequests, int $totalConfirmed): void
    {
        echo "<h2>Weekly Report ({$this->startDate} to {$this->endDate})</h2>";

        if ($totalRequests > 0) {
            echo "<p>Total Requests: {$totalRequests}</p>";
            echo "<p>Confirmed Requests: {$totalConfirmed}</p>";
        } else {
            echo "<p>No requests found this week.</p>";
        }

        echo '<a href="manager_dashboard.php">Back to Dashboard</a>';
    }

    public function displayError(string $message): void
    {
        echo "<p style='color:red;'>Error: {$message}</p>";
    }
}

date_default_timezone_set('Asia/Singapore');

$boundary = new GenerateWeeklyReportBoundary();
$controller = new WeeklyReportController($boundary);
$controller->getReportByWeek();
?>
