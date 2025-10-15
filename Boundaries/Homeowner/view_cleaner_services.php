<?php
session_start();
require_once __DIR__ . '/../../Controllers/Homeowner/ViewCleaningServiceController.php';
require_once __DIR__ . '/../../Controllers/Homeowner/IncrementServiceViewCountController.php';
require_once __DIR__ . '/../../Controllers/Shortlists/AddShortlistController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'])) {
    $controller = new AddShortlistController();
	$controller->add($_SESSION['user']['id'], $_POST['job_id']);
    header("Location: view_cleaner_services.php?job_id={$_POST['job_id']}&status=shortlisted");
    exit;
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

$jobId = $_GET['job_id'] ?? null;

if ($jobId) {
    $incrementController = new IncrementServiceViewCountController();
    $incrementController->increment($jobId, $_SESSION['user']['id']);

} else {
    echo "Missing service job ID.";
  exit;
}

$serviceController = new ViewCleaningServiceController();
$service = $serviceController->getServiceById($jobId);

if (!$service) {
    echo "Service not found.";
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Detail</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #1e293b;
        }

        .container {
            background-color: white;
            max-width: 900px;
            width: 95%;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            padding: 32px;
            margin: 40px 0;
            transition: all 0.3s ease-in-out;
        }

        h2 {
            text-align: center;
            font-size: 30px;
            color: #0f172a;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 18px 22px;
            text-align: left;
            font-size: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background-color: #f9fafb;
            color: #1e293b;
            font-weight: 600;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .favorite-btn, .confirm-btn {
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .favorite-btn {
            background-color: #6366f1;
            color: #fff;
            margin-top: 5px;
        }

        .favorite-btn:hover {
            background-color: #4f46e5;
        }

        .confirm-btn {
            background-color: #10b981;
            color: #fff;
            margin-bottom: 8px;
        }

        .confirm-btn:hover {
            background-color: #059669;
        }

        .disabled-btn {
            background-color: #cbd5e1;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: not-allowed;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-weight: 600;
            color: #6366f1;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                background-color: #f9fafb;
                margin-bottom: 16px;
                border-radius: 12px;
                padding: 16px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }

            td {
                border: none;
                padding: 10px 0;
                font-size: 14px;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #6b7280;
                display: block;
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🧹 Service Detail</h2>

    <?php if ($service):?>
        <table>
            <thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Price</th>
					<th>Action</th>
				</tr>
			</thead>
           <tbody>
				<tr>
					<td data-label="Title"><?= htmlspecialchars($service['title']) ?></td>
					<td data-label="Description"><?= htmlspecialchars($service['description']) ?></td>
					<td data-label="Price">$<?= number_format($service['price'], 2) ?></td>
					<td data-label="Action">
    <?php if ($service['shortlisted'] > 0): ?>
        <span class="disabled-btn">Shortlisted</span>
    <?php else: ?>
        <form method="POST" action="confirm_job.php" style="margin-bottom: 8px;">
            <input type="hidden" name="job_id" value="<?= $service['job_id'] ?>">
            <input type="hidden" name="cleaner_id" value="<?= $service['cleaner_id'] ?>">
            <button type="submit" class="confirm-btn">Confirm Booking</button>
        </form>

        <form method="POST" action="">
            <input type="hidden" name="job_id" value="<?= $service['job_id'] ?>">
            <button type="submit" class="favorite-btn">Shortlist</button>
        </form>
    <?php endif; ?>
</td>

				</tr>
		</tbody>
</table>
    <?php else: ?>
        <p style="text-align:center; color:#6b7280;">No services available.</p>
    <?php endif; ?>
    <a href="view_favorites.php" class="back-link">Back to Favorite List</a>
</div>
</body>
</html>