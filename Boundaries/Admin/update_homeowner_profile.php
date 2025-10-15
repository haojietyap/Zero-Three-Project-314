<?php
session_start();
require_once __DIR__ . '/../../Controllers/Profiles/Homeowner/UpdateHomeownerProfileController.php';
require_once __DIR__ . '/../../Controllers/Profiles/Homeowner/ViewHomeownerProfileController.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

$userId = $_GET['id'];

$viewController = new ViewHomeownerProfileController();
$updateController = new UpdateHomeownerProfileController();

$profile = $viewController->getProfileByUserId($userId);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $preferredCleaningTime = $_POST['preferred_cleaning_time'];
    $cleaningFrequency = $_POST['cleaning_frequency'];
    $languagePreference = $_POST['language_preference'];

    if ($updateController->updateProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference)) {
        $message = "Profile updated successfully.";
      
        $profileData = $viewController->getProfileByUserId($userId);
    } else {
        $message = "Failed to update profile.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Homeowner Profile</title>
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
    <h1>Update Homeowner Profile</h1>
    <a class="logout-link" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>

<div class="container">
    <h2>Edit Homeowner Details</h2>

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

            <label>Preferred Cleaning Time:</label>
            <select name="preferred_cleaning_time" required>
                <option value="">Select Time</option>
                <option value="morning" <?= $profile['preferred_cleaning_time'] === 'morning' ? 'selected' : '' ?>>Morning</option>
                <option value="afternoon" <?= $profile['preferred_cleaning_time'] === 'afternoon' ? 'selected' : '' ?>>Afternoon</option>
                <option value="evening" <?= $profile['preferred_cleaning_time'] === 'evening' ? 'selected' : '' ?>>Evening</option>
            </select>

            <label>Cleaning Frequency:</label>
            <select name="cleaning_frequency" required>
                <option value="">Select Frequency</option>
                <option value="weekly" <?= $profile['cleaning_frequency'] === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                <option value="biweekly" <?= $profile['cleaning_frequency'] === 'biweekly' ? 'selected' : '' ?>>Biweekly</option>
                <option value="monthly" <?= $profile['cleaning_frequency'] === 'monthly' ? 'selected' : '' ?>>Monthly</option>
            </select>

            <label>Language Preference:</label>
            <select name="language_preference" required>
                <option value="">Select Language</option>
                <option value="english" <?= $profile['language_preference'] === 'english' ? 'selected' : '' ?>>English</option>
                <option value="malay" <?= $profile['language_preference'] === 'malay' ? 'selected' : '' ?>>Malay</option>
                <option value="mandarin" <?= $profile['language_preference'] === 'mandarin' ? 'selected' : '' ?>>Mandarin</option>
                <option value="tamil" <?= $profile['language_preference'] === 'tamil' ? 'selected' : '' ?>>Tamil</option>
            </select>

            <button type="submit">Update Profile</button>
        </form>
    <?php else: ?>
        <p class="error">User profile not found.</p>
    <?php endif; ?>

    <a class="back-link" href="manage_profiles.php">Back to User List</a>
</div>

</body>
</html>
