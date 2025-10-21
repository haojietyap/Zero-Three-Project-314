<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/User.php';

function redirect(string $to, array $qs = []): void
{
    if ($qs) $to .= (strpos($to, '?') === false ? '?' : '&') . http_build_query($qs);
    header("Location: $to");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
if ($id <= 0) redirect('./ViewUsersController.php', ['error' => 'Missing user id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $role     = $_POST['role'] ?? '';
    $password = trim($_POST['password'] ?? '');

    if ($name === '' || $email === '') {
        redirect("./EditUserController.php", ['id' => $id, 'error' => 'Name and Email required.']);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect("./EditUserController.php", ['id' => $id, 'error' => 'Invalid email.']);
    }
    if (User::emailExistsForOther($conn, $email, $id)) {
        redirect("./EditUserController.php", ['id' => $id, 'error' => 'Email already in use.']);
    }

    $ok = User::update($conn, $id, $name, $email, $role, $password === '' ? null : $password);
    $ok ? redirect('./ViewUsersController.php', ['msg' => 'User updated.'])
        : redirect("./EditUserController.php", ['id' => $id, 'error' => 'Update failed.']);
}

$user = User::findById($conn, $id);
if (!$user) redirect('./ViewUsersController.php', ['error' => 'User not found']);

$roles = User::fetchRoles($conn);
$view  = 'edit';
include __DIR__ . '/../Boundary/user_list.php';
