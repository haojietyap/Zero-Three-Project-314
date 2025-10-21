<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/User.php';

function goBack(array $qs = []): void
{
    $url = './ViewUsersController.php';
    if ($qs) $url .= '?' . http_build_query($qs);
    header("Location: $url");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') goBack(['error' => 'Invalid request.']);

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$action = $_POST['action'] ?? '';

if ($id <= 0 || !in_array($action, ['activate', 'suspend'], true)) goBack(['error' => 'Invalid parameters.']);

$newStatus = $action === 'activate' ? 'Active' : 'Inactive';
if (User::setStatus($conn, $id, $newStatus)) {
    goBack(['msg' => $newStatus === 'Active' ? 'User activated.' : 'User suspended.']);
}
goBack(['error' => 'Failed to update status.']);
