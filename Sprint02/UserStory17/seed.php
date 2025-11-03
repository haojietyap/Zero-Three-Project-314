<?php
require_once __DIR__ . '/Entity/Request.php';

// Example seed data
$data = [
    ['id' => 1, 'userID' => 1, 'title' => 'Fix network issue', 'status' => 'Open', 'createdAt' => '2025-10-01'],
    ['id' => 2, 'userID' => 1, 'title' => 'Replace laptop', 'status' => 'Closed', 'createdAt' => '2025-09-20'],
    ['id' => 3, 'userID' => 2, 'title' => 'Software update', 'status' => 'Pending', 'createdAt' => '2025-10-15'],
    ['id' => 4, 'userID' => 1, 'title' => 'Request new monitor', 'status' => 'Pending', 'createdAt' => '2025-10-10'],
];

Request::seed($data);

echo "Seed data loaded successfully!";
