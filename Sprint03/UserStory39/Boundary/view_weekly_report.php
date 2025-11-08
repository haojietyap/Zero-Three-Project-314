<?php
require_once __DIR__ . '/../controller/WeeklyReportController.php';
date_default_timezone_set('Asia/Singapore');

$controller = new weeklyReportController();

$stats = $controller->getReportByWeek($startDate, $endDate);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weekly Report</title>
</head>
<body>

<h2>Weekly Report (<?= $startDate ?> to <?= $endDate ?>)</h2>

<?php if ($stats['totalRequests'] > 0): ?>
    <p>Total Requests: <?= $stats['totalRequests'] ?></p>
    <p>Confirmed Requests: <?= $stats['totalConfirmed'] ?></p>
<?php else: ?>
    <p>No requests found this week.</p>
<?php endif; ?>

<a href="manager_dashboard.php">Back to Dashboard</a>

</body>
</html>
