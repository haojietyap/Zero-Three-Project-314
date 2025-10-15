<?php
session_start();
require_once __DIR__ . '/../../Controllers/Profiles/Cleaner/CreateCleanerProfileController.php';
require_once __DIR__ . '/../../Controllers/Service Category/GetServiceCategoriesController.php';

$userId = $_GET['id'] ?? null;

$getServiceCategoriesController = new GetServiceCategoriesController();
$categories = $getServiceCategoriesController->getAll();

$createCleanerProfileController = new CreateCleanerProfileController();

$message = '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $preferredCleaningTime = $_POST['preferred_cleaning_time'] ?? '';
    $cleaningFrequency = $_POST['cleaning_frequency'] ?? '';
    $languagePreference = $_POST['language_preference'] ?? '';
    $preferredCategoryId = $_POST['expertise'] ?? '';

    $result = $createCleanerProfileController->createProfile(
        $userId, $phone, $address, $experience,
        $preferredCleaningTime, $cleaningFrequency,
        $languagePreference, $preferredCategoryId, $rating
    );

    if ($result === 'exists') {
        $message = "Cleaner profile already exists.";
    } elseif ($result === 'success') {
        $message = "Cleaner profile created successfully.";
    } else {
        $message = "An error occurred while creating the profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Cleaner Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
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
        nav h1 { font-size: 24px; }
        .reset-link {
            background-color: #f87171;
            color: white;
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .reset-link:hover { background-color: #ef4444; }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        h2 { font-size: 28px; margin-bottom: 28px; text-align: center; }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 16px;
            background-color: #f5f5f5;
        }
        textarea { resize: vertical; }
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
        button:hover { background-color: #26699e; }
        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .success { color: green; }
        .error { color: red; }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #326aad;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover { text-decoration: underline; }
        @media (max-width: 600px) {
            .container { margin: 20px; padding: 20px; }
            nav { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<nav>
    <h1>Create Cleaner Profile</h1>
    <a class="reset-link" href="../logout.php">Logout</a>
</nav>

<div class="container">
    <h2>Cleaner Information</h2>

    <?php if ($message): ?>
        <p class="message <?= $result === 'success' ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
	
        <label>Phone:</label>
        <input type="text" name="phone" required>

        <label>Address:</label>
        <input type="text" name="address" required>

        <label>Experience:</label>
        <textarea name="experience" rows="3" required></textarea>

        <label>Rating:</label>
        <input type="text" name="rating" required>

        <label>Expertise:</label>
        <select name="expertise" required>
            <option value="">--Select a Category--</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Preferred Cleaning Time:</label>
        <select name="preferred_cleaning_time" required>
            <option value="">--Select Time--</option>
            <option value="morning">Morning</option>
            <option value="afternoon">Afternoon</option>
            <option value="evening">Evening</option>
        </select>

        <label>Cleaning Frequency:</label>
        <select name="cleaning_frequency" required>
            <option value="">--Select Frequency--</option>
            <option value="weekly">Weekly</option>
            <option value="biweekly">Biweekly</option>
            <option value="monthly">Monthly</option>
        </select>

        <label>Language Preference:</label>
        <select name="language_preference" required>
            <option value="">--Select Language--</option>
            <option value="english">English</option>
            <option value="mandarin">Mandarin</option>
            <option value="malay">Malay</option>
            <option value="tamil">Tamil</option>
        </select>

        <button type="submit">Create Profile</button>
    </form>

    <a class="back-link" href="manage_profiles.php">Back to Profile List</a>
</div>

</body>
</html>
