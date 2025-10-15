<?php
session_start();
require_once __DIR__ . '/../../Controllers/Homeowner/ViewCleanerController.php';
require_once __DIR__ . '/../../Controllers/Homeowner/SearchCleanersController.php';
require_once __DIR__ . '/../../Controllers/Homeowner/CheckFavoriteStatusController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: /314/Boundaries/login.php");
    exit;
}

$searchController = new SearchCleanersController();
$viewController = new ViewCleanersController();
$checkFavoriteController = new CheckFavoriteStatusController();

$homeownerId = $_SESSION['user']['id'];

$keyword = $_GET['search'] ?? '';
$cleaners = !empty($keyword)
    ? $searchController->searchByCategoryOrRating($keyword)
    : $viewController->getAllActiveCleaners();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Cleaners</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('../img/cleaner.jpg') no-repeat center center;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* Dark overlay for readability */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        h2 {
            font-size: 36px;
            font-weight: 600;
            margin-top: 40px;
            margin-bottom: 20px;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .search-bar {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
        }

        .search-bar input[type="text"] {
            padding: 14px 20px;
            width: 280px;
            border-radius: 30px;
            border: 2px solid #fff;
            background-color: rgba(255,255,255,0.2);
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        ::placeholder {
            color: #f3f4f6;
            opacity: 1;
        }

        .search-bar input[type="text"]:focus {
            background-color: rgba(255,255,255,0.3);
            border-color: #3b82f6;
        }

        .search-bar button,
        .search-bar .reset-link {
            padding: 14px 20px;
            border: none;
            border-radius: 30px;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .search-bar button:hover,
        .search-bar .reset-link:hover {
            background-color: #2563eb;
        }

        .cleaner-list {
            max-width: 900px;
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cleaner-card {
            background: rgba(30, 41, 59, 0.6); /* darkened for readability */
            backdrop-filter: blur(6px);
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 6px 24px rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            color: #fff;
            transition: all 0.3s ease;
        }

        .cleaner-card:hover {
            background: rgba(30, 41, 59, 0.75);
        }

        .cleaner-details {
            flex: 1;
            min-width: 250px;
        }

        .cleaner-details p {
            margin: 6px 0;
            font-size: 16px;
            font-weight: 500;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }

        .favorite-btn, .view-btn, .favorited-label {
            padding: 12px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .favorite-btn {
            background-color: #3b82f6;
            color: white;
        }

        .favorite-btn:hover {
            background-color: #2563eb;
        }

        .view-btn {
            background-color: #10b981;
            color: white;
        }

        .view-btn:hover {
            background-color: #059669;
        }

        .favorited-label {
            background-color: #9ca3af;
            color: white;
            cursor: default;
        }

        .back-link {
            margin: 40px auto;
            text-align: center;
            color: #93c5fd;
            font-weight: bold;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .cleaner-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-bar {
                flex-direction: column;
                align-items: center;
            }

            .search-bar input[type="text"] {
                width: 200%;
            }

            .actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>

<h2>✨ Browse Available Cleaners</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'added'): ?>
    <p style="text-align:center; color: #4ade80; font-weight: bold;">Cleaner added to favorites.</p>
<?php endif; ?>

<div class="search-bar">
    <form method="GET" style="display: flex; gap: 10px;">
        <input type="text" name="search" placeholder="Search by expertise, rating, or location" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Search</button>
        <a class="reset-link" href="view_cleaners.php">Reset</a>
    </form>
</div>

<div class="cleaner-list">
    <?php foreach ($cleaners as $cleaner): ?>
        <?php $isFavorited = $checkFavoriteController->isFavorited($homeownerId, $cleaner['user_id']); ?>
        <div class="cleaner-card">
            <div class="cleaner-details">
                <p><strong>Name:</strong> <?= htmlspecialchars($cleaner['name']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($cleaner['address']) ?></p>
                <p><strong>Cleaning Expertise:</strong> <?= htmlspecialchars($cleaner['category_name']) ?></p>
                <p><strong>Rating:</strong> <?= $cleaner['rating'] ?? '-' ?></p>
            </div>
           <div class="actions">
			<?php if ($isFavorited): ?>
				<span class="favorited-label">Favorited</span>
			<?php else: ?>
				<a class="favorite-btn" href="favorite_cleaner.php?cleaner_id=<?= htmlspecialchars($cleaner['user_id']) ?>">Favorite</a>
			<?php endif; ?>
				<a class="btn view-btn" href="view_cleaner_profile_homeowner.php?id=<?= htmlspecialchars($cleaner['user_id']) ?>">View Profile</a>
			</div>
        </div>
    <?php endforeach; ?>
</div>

<a href="homeowner_dashboard.php" class="back-link">Back to Dashboard</a>

</body>
</html>
