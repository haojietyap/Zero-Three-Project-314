<?php
require_once __DIR__ . '/../Entity/DailyReport.php';
require_once __DIR__ . '/../Controller/DailyReportController.php';

class GenerateDailyReportBoundary
{
    private string $selectedDate;

    public function __construct()
    {
        $this->selectedDate = $_GET['date'] ?? date('Y-m-d'); // default to today
    }

    public function getSelectedDate(): string
    {
        return $this->selectedDate;
    }

    public function displayGenerateReport(int $totalRequests, int $totalConfirmed): void
    {
        echo "<h2>Daily Report for {$this->selectedDate}</h2>";
        echo "<ul>";
        echo "<li>Total Requests Created: {$totalRequests}</li>";
        echo "<li>Total Requests Confirmed: {$totalConfirmed}</li>";
        echo "</ul>";
        echo '<a href="manager_dashboard.php">Back to Dashboard</a>';
    }

    public function displayEmpty(): void
    {
        echo "<p>No requests were created or confirmed on this date.</p>";
    }

    public function displayError(string $message): void
    {
        echo "<p style='color:red;'>Error: {$message}</p>";
    }
}

date_default_timezone_set('Asia/Singapore');

$boundary = new GenerateDailyReportBoundary();
$controller = new DailyReportController($boundary);
$controller->getReportByDate();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Report</title>
</head>
<body>

<div>
    <h2>Daily Report: Jobs Confirmed on : <span><?= $today ?></span></h2>

    <table>
        <tr>
            <th>Total Confirmed Jobs</th>
        </tr>
        <tr>
            <td><strong><?= $data['total'] ?></strong></td>
        </tr>
    </table>

    <a href="manager_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>



