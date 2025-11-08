<?php
require_once __DIR__ . '/../controller/MonthlyReportController.php';
date_default_timezone_set('Asia/Singapore');

$controller = new monthlyReportController();

// Example: current month
$year = date('Y');
$month = date('m');

$stats = $controller->getReportByMonth($year, $month);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Report</title>
</head>
<body>

<h2>Monthly Report: <?= $year ?>-<?= str_pad($month, 2, '0', STR_PAD_LEFT) ?></h2>

<?php if ($stats['totalRequests'] > 0): ?>
    <p>Total Requests: <?= $stats['totalRequests'] ?></p>
    <p>Confirmed Requests: <?= $stats['totalConfirmed'] ?></p>
<?php else: ?>
    <p>No requests found this month.</p>
<?php endif; ?>

<a href="manager_dashboard.php">Back to Dashboard</a>

</body>
</html>
