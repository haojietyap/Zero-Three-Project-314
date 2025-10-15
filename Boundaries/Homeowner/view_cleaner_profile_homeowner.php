<?php
session_start();
require_once __DIR__ . '/../../Controllers/Profiles/Cleaner/ViewCleanerProfileController.php';
require_once __DIR__ . '/../../Controllers/Homeowner/HomeownerViewCleaningServicesController.php';
require_once __DIR__ . '/../../Controllers/Service Category/ViewServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}
$userId = $_GET['id'] ?? null;
$cleanerId = $_GET['id'] ?? null;

if (!$cleanerId) {
    echo "Cleaner ID is required.";
    exit;
}

$profileController = new ViewCleanerProfileController();
$serviceController = new HomeownerViewCleaningServicesController();
$categoryController = new ViewServiceCategoryController();

$profile = $profileController->getProfile($cleanerId);
$services = $serviceController->getOfferedServicesByCleaner($cleanerId);

$categoryName = '';
if ($profile && !empty($profile['expertise'])) {
    $category = $categoryController->getCategoryById($profile['expertise']);
    $categoryName = $category ? $category['name'] : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Cleaner Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
            background: url('../img/cleanerprofile.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .container {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 30px;
            margin: 60px auto;
            max-width: 800px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.4);
        }

        label {
            display: block;
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 6px;
            font-size: 15px;
            color: #d1d5db;
        }

        input[type="text"] {
            width: 100%;
			box-sizing: border-box;
            padding: 12px 16px;
            font-size: 16px;
            border-radius: 12px;
            border: none;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            margin-bottom: 10px;
        }

        input[type="text"]::placeholder {
            color: #ccc;
        }

        input[readonly] {
            background-color: rgba(255, 255, 255, 0.2);
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 22px;
            color: #93c5fd;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        li {
            margin-bottom: 14px;
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 16px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-btn {
            background-color: #7DDA58;
            color: white;
            padding: 10px 18px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .view-btn:hover {
            background-color: #63c94a;
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
            color: #bfdbfe;
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            li {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
		
		.center-buttons {
			text-align: center;
			margin-top: 20px;
	}
		
		.btn-nav {
			display: inline-block;
			padding: 10px 20px;
			margin: 10px 5px;
			background-color: #1a8cff;
			color: white;
			text-decoration: none;
			font-weight: 600;
			border-radius: 8px;
			transition: background-color 0.3s;
	}

	.btn-nav:hover {
		background-color: #006fd6;
	}

    </style>
</head>
<body>
<div class="container">
        <h2>Cleaner Profile</h2>
		
        <label>Phone:</label>
        <input type="text" value="<?= htmlspecialchars($profile['phone']) ?>" readonly>

        <label>Address:</label>
        <input type="text" value="<?= htmlspecialchars($profile['address']) ?>" readonly>

        <label>Experience:</label>
        <input type="text" value="<?= htmlspecialchars($profile['experience']) ?>" readonly>

        <label>Expertise:</label>
        <input type="text" value="<?= htmlspecialchars($categoryName) ?>" readonly>

        <label>Preferred Cleaning Time:</label>
        <input type="text" value="<?= htmlspecialchars($profile['preferred_cleaning_time']) ?>" readonly>

        <label>Cleaning Frequency:</label>
        <input type="text" value="<?= htmlspecialchars($profile['cleaning_frequency']) ?>" readonly>

        <label>Language Preference:</label>
        <input type="text" value="<?= htmlspecialchars($profile['language_preference']) ?>" readonly>

        <label>Status:</label>
        <input type="text" value="<?= htmlspecialchars($profile['status']) ?>" readonly>

<h3>Services Offered by This Cleaner:</h3>
<?php if (!empty($services)): ?>
    <ul>
        <?php foreach ($services as $service): ?>
            <li>
                <?= htmlspecialchars($service['title']) ?>
                <a href="view_cleaner_services.php?cleaner_id=<?= $cleanerId ?>&job_id=<?= $service['job_id'] ?>" class="view-btn">View Services</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p style="color: #888; font-style: italic;">No services available yet.</p>
<?php endif; ?>

<div class="center-buttons">
	<a href="view_cleaners.php" class="btn-nav">Back to Cleaner List</a>
    <a href="view_favorites.php" class="btn-nav">Back to Favorite List</a>
</div>


</body>
</html>