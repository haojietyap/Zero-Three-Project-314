<?php

require_once __DIR__ . '/../Controller/suspendProfileController.php';

$controller = new suspendProfileController();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_id   = isset($_POST['profile_id']) ? (int) $_POST['profile_id'] : 0;

    $result = $controller->suspendUserProfile($profile_id);

    if ($result) {
        $message = "✅ User profile suspended successfully.";
    } else {
        $message = "❌ No profile was suspended. The Profile ID may not exist, or the data is invalid.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Suspend User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
        }

        input {
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
        <h2>Suspend User Profile</h2>

        <?php if (!empty($message)) : ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Profile ID</label><br>
            <input type="number" name="profile_id" min="1" placeholder="Enter existing profile ID" required><br>

            <button type="submit">Suspend Profile</button>
        </form>
    </div>
</body>

</html>