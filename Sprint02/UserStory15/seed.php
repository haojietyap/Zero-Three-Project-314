<?php
require_once __DIR__ . '/Entity/Request.php';

Request::seed([
    [
        'id' => 1,
        'title' => 'Laptop Issue',
        'description' => 'My laptop battery is not charging.',
        'priority' => 'High',
        'status' => 'Open',
        'updatedAt' => date("Y-m-d H:i:s")
    ],
    [
        'id' => 2,
        'title' => 'Software Installation',
        'description' => 'Need Photoshop installed.',
        'priority' => 'Medium',
        'status' => 'Pending',
        'updatedAt' => date("Y-m-d H:i:s")
    ]
]);
?>
