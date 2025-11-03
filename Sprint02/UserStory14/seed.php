<?php
// seed.php
require_once __DIR__ . '/Entity/Request.php';

$data = [
    ['id' => 1, 'userID' => 1, 'title' => 'Access Request A', 'status' => 'Approved', 'createdAt' => '2025-10-01'],
    ['id' => 2, 'userID' => 1, 'title' => 'Access Request B', 'status' => 'Pending',  'createdAt' => '2025-10-15'],
    ['id' => 3, 'userID' => 2, 'title' => 'Change Request X', 'status' => 'Rejected', 'createdAt' => '2025-09-21']
];

Request::seed($data);
?>
