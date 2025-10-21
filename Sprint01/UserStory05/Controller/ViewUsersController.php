<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/User.php';

$users = User::fetchAll($conn);
$view  = 'list';
include __DIR__ . '/../Boundary/user_list.php';
