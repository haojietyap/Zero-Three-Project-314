<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/User.php';

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    header('Location: ./ViewUsersController.php');
    exit;
}

$users   = User::search($conn, $q);
$searchQ = $q;
$view    = 'search';
include __DIR__ . '/../Boundary/user_list.php';
