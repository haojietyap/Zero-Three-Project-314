<?php
session_start();
require_once __DIR__ . '/../../Controllers/profiles/Admin/UpdateAdminProfileController.php';
require_once __DIR__ . '/../../Controllers/profiles/Admin/ViewAdminProfileController.php';

$userId = $_GET['id'] ?? null;
$message = '';

if (!$userId) {
    header("Location: manage_profiles.php");
    exit;
}

$viewController = new ViewAdminProfileController();
$updateController = new UpdateAdminProfileController();

$profile = $viewController->getProfileByUserId($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($updateController->update($userId, $phone, $address)) {
        $message = "Profile updated successfully.";
    
        $profile = $viewController->getProfileByUserId($userId);
    } else {
        $message = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Admin Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            background-color: #fefefe;
        }

        textarea {
            resize: vertical;
        }

        button {
			background-color: #3b82f6; 
			color: #fff;
			padding: 14px;
			border: none;
			border-radius: 12px;
			cursor: pointer;
			width: 100%;
			font-size: 16px;
			font-weight: 600;
			transition: background-color 0.3s ease;
		}		

		button:hover {
			background-color: #2563eb; 
		
		}
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
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
    <h1>Update Admin Profile</h1>
    <a class="logout-link" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>

<div class="container">
    <h2>Edit Admin Details</h2>

    <?php if (!empty($message)): ?>
        <div class="message <?= strpos($message, 'success') !== false ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if ($profile): ?>
        <form method="POST">
                        <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($profile['phone']) ?>" required>

            <label>Address:</label>
            <textarea name="address" required><?= htmlspecialchars($profile['address']) ?></textarea>


            <button type="submit">Update Profile</button>
        </form>
    <?php else: ?>
        <p class="error">User profile not found.</p>
    <?php endif; ?>

    <a class="back-link" href="manage_profiles.php">Back to Profile List</a>
</div>

</body>
</html>