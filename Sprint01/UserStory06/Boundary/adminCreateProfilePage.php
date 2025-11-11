<?php

require_once __DIR__ . '/../Controller/createProfileController.php';

$controller = new createProfileController();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_name = $_POST['profile_name'] ?? '';
    $description  = $_POST['description'] ?? '';

    $result = $controller->createUserProfile($profile_name, $description);
    if ($result) {
        $message = "✅ User profile created successfully.";
    } else {
        $message = "❌ Failed to create user profile. Check the input or try another name.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create User Profile</title>
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
        <h2>Create User Profile</h2>

        <?php if (!empty($message)) : ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Profile Name</label><br>
            <input type="text" name="profile_name" placeholder="Enter profile/role name" required><br>

            <label>Description</label><br>
            <textarea name="description" rows="4" placeholder="Enter description (optional)"></textarea><br>

            <button type="submit">Create Profile</button>
        </form>
    </div>
</body>

</html>