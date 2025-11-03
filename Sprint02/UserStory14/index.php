<?php
// index.php
require_once __DIR__ . '/Boundary/viewMyRequestsBoundary.php';
require_once __DIR__ . '/seed.php'; // load mock data

// Example user ID (simulate logged-in user)
$userID = 1;

$boundary = new viewMyRequestsBoundary();
$boundary->viewMyRequests($userID);
?>
