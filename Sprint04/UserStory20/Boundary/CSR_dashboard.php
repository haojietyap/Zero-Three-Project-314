<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'CSR') {
    header("Location: login.php");
    exit;
}

$CSRName = $_SESSION['user']['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSR Dashboard</title>
</head>
<body>

    <nav>
        <h1>CSR Dashboard</h1>
        <a href="../logout.php">Logout</a>
    </nav>

    <div>
        <h2>Welcome, CSR</h2>
        <p>You are logged in as: <strong><?= htmlspecialchars($CSRName) ?></strong></p>

        <h3>Menu:</h3>
        <ul class="menu">
            <li><a href="search_requests.php"> Search For Requests</a></li>
            <li><a href="shortlist_requests.php">Shortlist Requests</a></li>
			<li><a href="view_shortlisted_requests.php">View Shortlisted Requests</a></li>
			<li><a href="search_completed_stats_CSR.php">Search For History</a></li>
        </ul>
    </div>

</body>

</html>
