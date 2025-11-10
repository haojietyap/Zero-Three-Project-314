<?php

require_once __DIR__ . '/../Controller/suspendAccountController.php';

$controller = new suspendAccountController();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $result = $controller->suspendUserAccount($email);
    $message = $result ? "✅ User account suspended successfully."
        : "❌ Failed to suspend user account. Check the email. ";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Suspend User Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 40px auto;
            text-align: center;
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
        <h2><u>Suspend User Account</u></h2>

        <?php if (!empty($message)) : ?>
            <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>

        <form method="post" action="">
            <input type="email" name="email" placeholder="Enter User Email to suspend" required><br>
            <button type="submit">Suspend</button>
        </form>
    </div>
</body>

</html>