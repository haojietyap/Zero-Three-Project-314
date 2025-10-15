<?php
session_start();
require_once __DIR__ . '/../../Controllers/Homeowner/GetFavoritesByHomeownerController.php';
require_once __DIR__ . '/../../Controllers/Homeowner/SearchFavoritesController.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

$homeownerId = $_SESSION['user']['id'];
$keyword = $_GET['search'] ?? '';

$favoriteController = new GetFavoritesByHomeownerController();
$searchController = new SearchFavoritesController();


$favorites = $keyword !== ''
    ? $searchController->search($homeownerId, $keyword)
    : $favoriteController->get($homeownerId);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Favorite Cleaners</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('../img/fav.jpg') no-repeat center center;
            background-size: cover;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            color: #fff;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Overlay */
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

        .container {
            max-width: 1000px;
            width: 100%;
            margin: 40px auto;
            padding: 30px;
            background-color: rgba(30, 41, 59, 0.6);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        form {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        input[type="text"] {
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

        input[type="text"]:focus {
            background-color: rgba(255,255,255,0.3);
            border-color: #3b82f6;
        }

        ::placeholder {
            color: #f3f4f6;
            opacity: 1;
        }

        button,
        .reset-link {
            padding: 14px 20px;
            border: none;
            border-radius: 30px;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        button:hover,
        .reset-link:hover {
            background-color: #2563eb;
        }

        .favorites-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 10px;
        }

        .favorite-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(4px);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            transition: all 0.3s ease;
            color: #fff;
        }

        .favorite-card:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .favorite-info {
            flex: 1;
            min-width: 250px;
        }

        .favorite-info p {
            margin: 6px 0;
            font-size: 16px;
            font-weight: 500;
        }

        .remove-btn {
            background-color: #ef4444;
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #dc2626;
        }
		
		.view-btn {
			background-color: #7DDA58;
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s ease;
		}

		.view-btn:hover {
			background-color: #0056b3;
		}

        .no-favorites {
            text-align: center;
            color: #d1d5db;
            font-size: 18px;
        }

        .back-link {
            display: block;
            margin-top: 40px;
            text-align: center;
            color: #93c5fd;
            font-weight: bold;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
            color: #bfdbfe;
        }

        @media (max-width: 600px) {
            .favorite-card {
                flex-direction: column;
                align-items: flex-start;
            }

            form input[type="text"] {
                width: 90%;
            }

            form {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>❤ My Favorite Cleaners</h2>

    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or category" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Search</button>
        <a class="reset-link" href="view_favorites.php">Reset</a>
    </form>

    <?php if (empty($favorites)): ?>
        <p class="no-favorites">No favorites found.</p>
    <?php else: ?>
        <div class="favorites-container">
            <?php foreach ($favorites as $favorite): ?>
                <div class="favorite-card">
                    <div class="favorite-info">
                        <p><strong>Name:</strong> <?= htmlspecialchars($favorite['name']) ?></p>
                        <p><strong>Category:</strong> <?= htmlspecialchars($favorite['category_name'] ?? '-') ?></p>
                    </div>
					
					<a class="btn view-btn" href="view_cleaner_profile_homeowner.php?id=<?= htmlspecialchars($favorite['cleaner_id']) ?>">View Profile</a>
					
                    <a class="remove-btn"
					href="remove_favorite.php?cleaner_id=<?php echo $favorite['cleaner_id']; ?>"
					onclick="return confirm('Remove this cleaner from favorites?');">
					Remove
					</a>
					
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="homeowner_dashboard.php" class="back-link">Back To Dashboard</a>
</div>

</body>
</html>
