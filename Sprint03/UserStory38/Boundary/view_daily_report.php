<?php
require_once __DIR__ . '/../../Controllers/Reports/DailyReportController.php';

date_default_timezone_set('Asia/Singapore');

$controller = new DailyReportController();
$result = $controller->getTodayCount();
$data = $result->fetch_assoc();
$today = date('d-m-y');
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



