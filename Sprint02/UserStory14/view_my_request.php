<?php
require_once 'Controller/controller.php';

// Simulate logged-in PIN user (example: user_id = 11)
$userID = 11;

$controller = new ViewMyRequestsController();
$controller->showMyRequests($userID);
?>
