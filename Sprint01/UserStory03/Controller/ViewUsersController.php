<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/User.php';

// this is Entity fetches all users
$users = User::fetchAll($conn);

// this renders the Boundary with $users available
include __DIR__ . '/../Boundary/view_users.php';
