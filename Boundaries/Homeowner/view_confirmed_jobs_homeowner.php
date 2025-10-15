<?php
session_start();
require_once __DIR__ . '/../../Controllers/ConfirmedJobs/ViewConfirmedJobsController.php';
require_once __DIR__ . '/../../Controllers/ConfirmedJobs/FilterConfirmedJobsByHomeownerController.php';
require_once __DIR__ . '/../../Controllers/Service Category/ViewServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

$homeownerId = $_SESSION['user']['id'];

$categoryController = new ViewServiceCategoryController();
$categories = $categoryController->getAllCategories();

$categoryId = isset($_GET['category_id']) ? (int) $_GET['category_id'] : null;
$startDate  = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate    = isset($_GET['end_date']) ? $_GET['end_date'] : null;

if ($categoryId || $startDate || $endDate) {
    $controller = new FilterConfirmedJobsByHomeownerController();
    $confirmedJobs = $controller->filter($homeownerId, $categoryId, $startDate, $endDate);
} else {
    $controller = new ViewConfirmedJobsController();
    $confirmedJobs = $controller->getByHomeowner($homeownerId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Service History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('../img/homeowner.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        .container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(30, 41, 59, 0.75);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            font-size: 32px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        select, input[type="date"] {
            padding: 10px 16px;
            border-radius: 30px;
            border: 2px solid #fff;
            background-color: #ffffff;
            color: #1e293b;
            font-size: 14px;
            outline: none;
        }

        select option {
            color: #1e293b;
            background-color: #ffffff;
        }

        button, .reset-link {
            padding: 12px 18px;
            border: none;
            border-radius: 30px;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        button:hover, .reset-link:hover {
            background-color: #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            color: #1e293b;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 14px 18px;
            text-align: left;
        }

        th {
            background-color: #1e3a8a;
            color: white;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.7);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #93c5fd;
            font-weight: bold;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            form {
                flex-direction: column;
                align-items: center;
            }
            table, form {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>My Service History</h2>

    <form method="GET">
        <select name="category_id">
            <option value="">-- All Categories --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= ($categoryId == $cat['category_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="start_date" value="<?= htmlspecialchars($startDate) ?>">
        <input type="date" name="end_date" value="<?= htmlspecialchars($endDate) ?>">

        <button type="submit">Search</button>
        <a href="view_confirmed_jobs_homeowner.php" class="reset-link">Reset</a>
    </form>

    <table>
        <tr>
            <th>Service Title</th>
            <th>Service Category</th>
            <th>Cleaner Name</th>
            <th>Status</th>
            <th>Matched Date</th>
            <th>Completion Date</th>
        </tr>

        <?php if ($confirmedJobs && $confirmedJobs->num_rows > 0): ?>
            <?php while ($job = $confirmedJobs->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($job['service_title']) ?></td>
                    <td><?= htmlspecialchars($job['category_name']) ?></td>
                    <td><?= htmlspecialchars($job['cleaner_name']) ?></td>
                    <td><?= htmlspecialchars($job['status']) ?></td>
                    <td><?= htmlspecialchars($job['matched_date']) ?></td>
                    <td><?= !empty($job['completion_date']) ? htmlspecialchars($job['completion_date']) : 'Pending' ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No confirmed jobs found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="homeowner_dashboard.php" class="back-link">Back to Dashboard</a>
</div>
</body>
</html>
