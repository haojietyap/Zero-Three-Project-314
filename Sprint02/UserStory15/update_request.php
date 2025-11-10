<?php
require_once 'Controller/controller.php';

// Example: PIN edits an existing request (ID = 1)
$requestID = 1;

$controller = new UpdateMyRequestController();
$controller->update($requestID);
?>
