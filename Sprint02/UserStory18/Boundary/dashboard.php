<?php

session_start();
if (!isset($_SESSION['auth'])) {
    header('Location: ../Boundary/login.php?error=Please+log+in');
    exit;
}
$me = $_SESSION['auth'];
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>PIN Dashboard</title>
</head>

<body>
    <h1>Welcome, <?php echo htmlspecialchars($me['name']); ?></h1>
    <p>Email: <?php echo htmlspecialchars($me['email']); ?></p>
    <p>Role: <?php echo htmlspecialchars($me['role']); ?></p>
    <p>Status: Active session</p>
</body>

</html>