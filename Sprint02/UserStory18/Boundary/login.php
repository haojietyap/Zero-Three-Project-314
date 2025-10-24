<?php

$error = $_GET['error'] ?? '';
$msg   = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>PIN Login</title>
</head>

<body>
    <h1>PIN Login</h1>

    <?php if ($error): ?>
        <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($msg): ?>
        <div style="color:green;"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <form method="post" action="../Controller/LoginController.php" autocomplete="off">
        <label>Email<br>
            <input type="email" name="email" required>
        </label><br><br>

        <label>Password<br>
            <input type="password" name="password" required>
        </label><br><br>

        <button type="submit">Log In</button>
    </form>
</body>

</html>