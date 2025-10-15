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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <style>

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
            pointer-events: none;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            margin-top: 100px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.65);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 90%;
            max-width: 600px;
            z-index: 10;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #fff;
        }
        h2 span {
    white-space: nowrap;
}


        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 16px;
            font-size: 18px;
        }

        th {
            background-color: #2563eb;
            color: #fff;
        }

        td {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.1);
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

        @media (max-width: 600px) {
            h2 {
                font-size: 22px;
            }

            th, td {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<video autoplay muted loop playsinline id="background-video">
    <source src="../img/view_report.mp4" type="video/mp4" />
    Your browser does not support the video tag.
</video>

<div class="container">
    <h2>Daily Report: Jobs Confirmed on : <span><?= $today ?></span></h2>


    <table>
        <tr>
            <th>Total Confirmed Jobs</th>
        </tr>
        <tr>
            <td><strong><?= $data['total'] ?></strong></td>
        </tr>
    </table>

    <a href="manager_dashboard.php" class="back-link">Back to Dashboard</a>
</div>

</body>
</html>


