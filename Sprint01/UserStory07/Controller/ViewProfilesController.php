<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/Profile.php';

$profiles = Profile::fetchAll($conn);
$view     = 'list';
include __DIR__ . '/../Boundary/profile_view.php';
