<?php

require_once __DIR__ . '/../Entity/User.php';
require_once __DIR__ . '/../Database/db_connect.php';

function redirect(string $to, array $qs = []): void
{
    if ($qs) {
        $to .= (strpos($to, '?') === false ? '?' : '&') . http_build_query($qs);
    }
    header("Location: $to");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../Boundary/create_user.php');
}

// this will collect the form input
$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$role     = $_POST['role'] ?? 'PIN';

// this will validate the input
if ($name === '' || $email === '' || $password === '') {
    redirect('../Boundary/create_user.php', ['error' => 'All fields are required.']);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect('../Boundary/create_user.php', ['error' => 'Invalid email address.']);
}

// this will use the Entity to perform operations
$userEntity = new User($conn);

if ($userEntity->emailExists($email)) {
    redirect('../Boundary/create_user.php', ['error' => 'Email already exists.']);
}

$created = $userEntity->create($name, $email, $password, $role);

if ($created) {
    redirect('../Boundary/create_user.php', ['msg' => 'User created successfully.']);
} else {
    redirect('../Boundary/create_user.php', ['error' => 'Failed to create a new user.']);
}
