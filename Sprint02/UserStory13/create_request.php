<?php
require_once 'Controller/controller.php';

$controller = new CreateRequestController();

// Simulate logged-in PIN user (e.g. user_id = 11)
$userID = 11;

$controller->createRequest($userID);
?>
