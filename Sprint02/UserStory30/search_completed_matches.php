<?php
require_once 'Controller/controller.php';

// Example: Logged-in PIN user (e.g., user_id = 11)
$userID = 11;

$controller = new SearchHistoricalMatchesController();
$controller->search($userID);
?>
