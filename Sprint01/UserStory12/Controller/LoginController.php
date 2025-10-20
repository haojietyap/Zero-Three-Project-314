
<?php

session_start();
require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Database/UserRepository.php';

function redirect(string $to, array $qs = []): void
{
    if ($qs) {
        $to .= (strpos($to, '?') === false ? '?' : '&') . http_build_query($qs);
    }
    header("Location: $to");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../Boundary/login.php');
}

$email    = trim($_POST['email'] ?? '');
$password = (string)($_POST['password'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
    redirect('../Boundary/login.php', ['error' => 'Please enter a valid email and password.']);
}

$repo   = new UserRepository($conn);
$result = $repo->verifyCredentials($email, $password);

if ($result['state'] === 'inactive') {
    redirect('../Boundary/login.php', ['error' => 'Account is inactive. Please contact the admin.']);
}
if ($result['state'] === 'invalid') {
    redirect('../Boundary/login.php', ['error' => 'Invalid email or password.']);
}

// if successful it will create a session and go to dashboard
$user = $result['user'];
$_SESSION['auth'] = [
    'id'    => $user->id,
    'name'  => $user->name,
    'email' => $user->email,
    'role'  => $user->role,
];
redirect('../Boundary/dashboard.php');
