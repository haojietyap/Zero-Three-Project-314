<?php
require_once __DIR__ . '/Boundary/createRequestBoundary.php';
require_once __DIR__ . '/Controller/createRequestController.php';

$boundary = new createRequestBoundary();
$controller = new createRequestController($boundary);

// Assume user with ID = 1
$userID = 1;

$controller->handleForm($userID);
?>
