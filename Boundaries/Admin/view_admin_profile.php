<?php
session_start();
require_once __DIR__ . '/../../Controllers/profiles/Admin/ViewAdminProfileController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

$userId = $_GET['id'] ?? null;
$message = '';

if (!$userId) {
    header("Location: manage_profiles.php");
    exit;
}

$viewController = new ViewAdminProfileController();
$profile = $viewController->getProfileByUserId($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Admin Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        }
        nav h1 { font-size: 24px; }
        nav a.logout-link {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
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
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            background-color: #f3f4f6;
            font-size: 16px;
            color: #444;
        }
        input[disabled], textarea[disabled] {
            background-color: #f9fafb;
            color: #888;
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
    </style>
</head>
<body>


<div class="container">
    <h2>Admin Profile</h2>

    <?php if ($profile): ?>
        <label>Phone:</label>
        <input type="text" value="<?= htmlspecialchars($profile['phone']) ?>" disabled>

        <label>Address:</label>
        <textarea disabled><?= htmlspecialchars($profile['address']) ?></textarea>
    <?php else: ?>
        <p style="color:red; text-align:center;">Profile not found.</p>
    <?php endif; ?>

    <a class="back-link" href="manage_profiles.php">Back to Profile List</a>
</div>

</body>
</html>



