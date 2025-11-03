<?php
require_once __DIR__ . '/Entity/Request.php';

// Fake initial data (as if fetched from DB)
$requests = [
    1 => ['title' => 'Laptop Repair Request', 'details' => 'Screen flickering issue.'],
    2 => ['title' => 'Access Request', 'details' => 'Need access to admin portal.'],
    3 => ['title' => 'Account Deletion', 'details' => 'User requested data removal.']
];

Request::seed($requests);
?>
