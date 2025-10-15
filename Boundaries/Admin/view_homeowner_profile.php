<?php
session_start();
require_once __DIR__ . '/../../Controllers/Profiles/Homeowner/ViewHomeownerProfileController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "User ID not provided.";
    exit;
}

$userId = $_GET['id'];

$viewHomeownerProfileController = new ViewHomeownerProfileController();
$profile = $viewHomeownerProfileController->getProfileByUserId($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Homeowner Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		html, body {
			margin: 0;
			padding: 0;
			height: 100%;
		}

		body {
			background: linear-gradient(135deg, #e0f7fa, #ffffff);
			font-family: 'Inter', sans-serif;
			color: #333;
			min-height: 100vh;
		}

        nav {
            background-color: #1a252f;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        nav h1 {
            font-size: 24px;
        }

        nav a.logout-link {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav a.logout-link:hover {
            color: #e67e22;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        h2 {
            font-size: 28px;
            margin-bottom: 28px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
            background-color: #f5f5f5;
        }

        .error {
            color: red;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #326aad;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            nav {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<nav>
    <h1>View Homeowner Profile</h1>
    <a class="logout-link" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>

<div class="container">
    <h2>Homeowner Profile</h2>

    <?php if ($profile): ?>

        <label>Phone:</label>
        <input type="text" value="<?= htmlspecialchars($profile['phone']) ?>" readonly>

        <label>Address:</label>
        <input type="text" value="<?= htmlspecialchars($profile['address']) ?>" readonly>

        <label>Status:</label>
        <input type="text" value="<?= htmlspecialchars($profile['status']) ?>" readonly>

        <label>Preferred Cleaning Time:</label>
        <input type="text" value="<?= htmlspecialchars($profile['preferred_cleaning_time']) ?>" readonly>

        <label>Cleaning Frequency:</label>
        <input type="text" value="<?= htmlspecialchars($profile['cleaning_frequency']) ?>" readonly>

        <label>Language Preference:</label>
        <input type="text" value="<?= htmlspecialchars($profile['language_preference']) ?>" readonly>
    <?php else: ?>
        <p class="error">This user does not have a profile yet.</p>
    <?php endif; ?>

    <a class="back-link" href="manage_profiles.php">Back to User List</a>
</div>

</body>
</html>
