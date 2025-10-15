<?php
session_start();
require_once __DIR__ . '/../../Controllers/profiles/Homeowner/CreateHomeownerProfileController.php';

$userId = $_GET['id'] ?? null;
$message = '';
$createHomeownerProfileController = new CreateHomeownerProfileController();

if ($userId && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $preferredCleaningTime = $_POST['preferred_cleaning_time'];
    $cleaningFrequency = $_POST['cleaning_frequency'];
    $languagePreference = $_POST['language_preference'];

    if ($createHomeownerProfileController->createProfile($userId, $phone, $address, $preferredCleaningTime, $cleaningFrequency, $languagePreference)) {
        $message = "Profile created successfully.";
    } else {
        $message = "Profile already exists or failed.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Homeowner Profile</title>
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

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
            background-color: #f5f5f5;
        }

        button {
            display: block;
            width: 100%;
            background-color: #2984d6;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #26699e;
        }

        .message {
            text-align: center;
            font-weight: bold;
            color: green;
            margin-bottom: 20px;
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
    <h1>Create Homeowner Profile</h1>
    <a class="logout-link" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>

<div class="container">
    <h2>Homeowner Information</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
		
	<form method="POST">
        <label>Phone:</label>
        <input type="text" name="phone" required>

        <label>Address:</label>
        <textarea name="address" rows="3" required></textarea>

        <label>Preferred Cleaning Time:</label>
        <select name="preferred_cleaning_time" required>
            <option value="">--Select Time--</option>
            <option value="Morning">Morning</option>
            <option value="Afternoon">Afternoon</option>
            <option value="Evening">Evening</option>
        </select>

        <label>Cleaning Frequency:</label>
        <select name="cleaning_frequency" required>
            <option value="">--Select Frequency--</option>
            <option value="Weekly">Weekly</option>
            <option value="Biweekly">Biweekly</option>
            <option value="Monthly">Monthly</option>
        </select>

        <label>Language Preference:</label>
        <select name="language_preference" required>
            <option value="">--Select Language--</option>
            <option value="English">English</option>
            <option value="Malay">Malay</option>
            <option value="Mandarin">Mandarin</option>
            <option value="Tamil">Tamil</option>
        </select>

        <button type="submit">Create Profile</button>
    </form>

    <a class="back-link" href="manage_profiles.php">Back to Manage Profiles</a>
</div>

</body>
</html>
