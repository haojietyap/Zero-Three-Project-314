<?php
require_once __DIR__ . '/../../Controllers/Reports/WeeklyReportController.php';

date_default_timezone_set('Asia/Singapore');

$controller = new WeeklyReportController();
$result = $controller->getStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weekly Report</title>
</head>
<body>

<div>
    <h2>Weekly Report: Completed Jobs by Service Category</h2>

    <table>
        <tr>
            <th>Service Category</th>
            <th style="text-align: center;">Completed Jobs (Last 7 Days)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['category_name']) ?></td>
            <td style="text-align: center;"><?= $row['total_completed'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>

