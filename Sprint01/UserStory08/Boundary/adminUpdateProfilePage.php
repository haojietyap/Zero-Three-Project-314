<?php

require_once __DIR__ . '/../Controller/updateProfileController.php';

$controller = new updateProfileController();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id   = isset($_POST['profile_id']) ? (int) $_POST['profile_id'] : 0;
    $profile_name = $_POST['profile_name'] ?? '';
    $description  = $_POST['description'] ?? '';

    $result = $controller->updateUserProfile($profile_id, $profile_name, $description);

    if ($result) {
        $message = "✅ User profile updated successfully.";
    } else {
        $message = "❌ No profile was updated. The Profile ID may not exist, or the data is invalid.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
        }

        button {
            padding: 8px 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Update User Profile</h2>

        <?php if (!empty($message)) : ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Profile ID</label><br>
            <input type="number" name="profile_id" min="1" placeholder="Enter existing profile ID" required><br>

            <label>Profile Name</label><br>
            <input type="text" name="profile_name" placeholder="Enter new profile name" required><br>

            <label>Description</label><br>
            <textarea name="description" rows="4" placeholder="Enter new description (optional)"></textarea><br>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>

</html>