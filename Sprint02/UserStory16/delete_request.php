<?php
require_once 'Controller/controller.php';

// Simulate user clicking delete on a request (example ID = 1)
$requestID = 1;

$controller = new DeleteMyRequestController();
$controller->delete($requestID);
?>
