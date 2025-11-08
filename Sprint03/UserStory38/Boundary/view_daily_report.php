<?php

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

    public function renderReport(int $totalRequests, int $totalConfirmed, string $date): void
    {
        echo "<h2>Daily Report for {$date}</h2>";
        echo "<ul>";
        echo "<li>Total Requests Created: {$totalRequests}</li>";
        echo "<li>Total Requests Confirmed: {$totalConfirmed}</li>";
        echo "</ul>";
    }

    public function renderEmpty(): void
    {
        echo "<p>No requests were created or confirmed on this date.</p>";
    }

    public function renderError(string $message): void
    {
        echo "<p style='color:red;'>Error: {$message}</p>";
    }
}
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



