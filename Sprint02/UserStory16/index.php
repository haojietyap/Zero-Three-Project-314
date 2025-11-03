<?php
require_once __DIR__ . '/Boundary/deleteMyRequestBoundary.php';
require_once __DIR__ . '/Controller/deleteMyRequestController.php';
require_once __DIR__ . '/Entity/Request.php';

// Include seed data if not already seeded
if (empty(Request::all())) {
    require_once __DIR__ . '/seed.php';
}

$boundary = new deleteMyRequestBoundary();
$controller = new deleteMyRequestController($boundary);

// Handle delete flow
if (isset($_GET['delete'])) {
    $controller->confirm((int)$_GET['delete']);
} elseif (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $controller->delete((int)$_POST['requestID']);
} else {
    // Default: show all requests
    $boundary->showSuccess(0); // show list without deleting
}
?>
