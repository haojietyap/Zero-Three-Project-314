<?php
require_once __DIR__ . '/../../Controllers/Reports/MonthlyReportController.php';

date_default_timezone_set('Asia/Singapore');

$controller = new MonthlyStatsReportController();
$result = $controller->getMonthlyStats();
$row = $result->fetch_assoc();

$activeCleaners = $row['active_cleaners'];
$completedJobs = $row['completed_jobs'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            height: 100%;
        }

        body {
            position: relative;
            overflow-x: hidden;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
            pointer-events: none;
        }

        .container {
            position: relative;
            z-index: 1;
            padding: 40px;
            max-width: 900px;
            margin: 60px auto;
            background: rgba(0, 0, 0, 0.65);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        th, td {
            padding: 14px;
            font-size: 18px;
        }

        th {
            background-color: #2563eb;
            text-align: left;
        }

        td {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .button-wrapper {
            text-align: center;
        }

        .back-link {
            display: inline-block;
            margin-top: 10px;
            color: #3b82f6;
            font-weight: bold;
            text-decoration: none;
            border: 2px solid #3b82f6;
            padding: 10px 20px;
            border-radius: 30px;
            transition: 0.3s ease;
        }

        .back-link:hover {
            background-color: #2563eb;
            color: white;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 30px 10px;
            }

            h2 {
                font-size: 22px;
            }

            th, td {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<video class="video-bg" autoplay muted loop playsinline>
    <source src="../img/view_report.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="container">
    <h2>Monthly Report: Engagement Overview (Last 30 Days)</h2>

    <table>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Number Of Cleaners Who Had Confirmed Jobs</td>
            <td><strong><?= $activeCleaners ?></strong></td>
        </tr>
        <tr>
            <td>Total Of Completed Jobs</td>
            <td><strong><?= $completedJobs ?></strong></td>
        </tr>
    </table>

    <div class="button-wrapper">
        <a href="manager_dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
