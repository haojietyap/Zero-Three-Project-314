<?php

require_once __DIR__ . '/../Controller/updateAccountController.php';

$controller = new updateAccountController();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'] ?? '';
    $field    = $_POST['field'] ?? '';
    $newValue = $_POST['new_value'] ?? '';

    $result = $controller->updateUserAccount($email, $field, $newValue);

    if ($result) {
        $message = "✅ Field updated successfully.";
    } else {
        $message = "❌ Failed to update field. Check the email, field, or value.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 40px auto;
            text-align: center;
        }

        input,
        select {
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
        <h2><u>Update Account</u></h2>

        <?php if (!empty($message)) : ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>

        <form method="post" action="">
            <input type="email" name="email" placeholder="Enter User Email to update" required><br>

            <label>Field to Update</label>
            <select name="field" required>
                <option value="">-- Select Field --</option>
                <option value="username">Username</option>
                <option value="email">Email</option>
                <option value="phone">Phone</option>
                <option value="role">Role / Profile (profile_id)</option>
                <option value="status">Status (ACTIVE/SUSPENDED)</option>
                <option value="password">Password</option>
            </select><br>

            <label>Update Value</label>
            <input type="text" name="new_value" placeholder="Enter value to update" required><br>

            <button type="submit">Update</button>
        </form>
    </div>
</body>

</html>