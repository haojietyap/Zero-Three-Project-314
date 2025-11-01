<?php
require_once __DIR__ . '/../../Controllers/Reports/MonthlyReportController.php';

date_default_timezone_set('Asia/Singapore');

$controller = new MonthlyStatsReportController();
$result = $controller->getMonthlyStats();
$row = $result->fetch_assoc();

$activeCSR = $row['active_CSR'];
$completedJobs = $row['completed_jobs'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Report</title>
</head>
<body>

<div>
    <h2>Monthly Report: Engagement Overview (Last 30 Days)</h2>

    <table>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Number Of CSR Who Had Confirmed Jobs</td>
            <td><strong><?= $activeCSR ?></strong></td>
        </tr>
        <tr>
            <td>Total Of Completed Jobs</td>
            <td><strong><?= $completedJobs ?></strong></td>
        </tr>
    </table>

    <div>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>

