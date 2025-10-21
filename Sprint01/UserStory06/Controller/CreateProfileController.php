<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/Profile.php';

function redirect(string $to, array $qs = []): void
{
    if (!empty($qs)) {
        $to .= (strpos($to, '?') === false ? '?' : '&') . http_build_query($qs);
    }
    header("Location: $to");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role        = $_POST['role'] ?? '';
    $permissions = trim($_POST['permissions'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // this will validate role matches ENUM options
    $allowed = Profile::allowedRoles();
    if (!in_array($role, $allowed, true)) {
        redirect('../Boundary/create_profile.php', ['error' => 'Invalid role selected.']);
    }

    // this will prevent duplicates (role is UNIQUE in DB)
    if (Profile::existsByRole($conn, $role)) {
        redirect('../Boundary/create_profile.php', ['error' => 'This role already exists in profiles.']);
    }

    // this is basic validation
    if ($permissions === '' || $description === '') {
        redirect('../Boundary/create_profile.php', ['error' => 'Permissions and description are required.']);
    }

    $ok = Profile::create($conn, $role, $permissions, $description);
    if ($ok) {
        redirect('../Boundary/create_profile.php', ['msg' => 'Profile created successfully.']);
    }
    redirect('../Boundary/create_profile.php', ['error' => 'Failed to create profile.']);
    exit;
}

// this is GET, which loads the allowed roles and show form
$roles = Profile::allowedRoles();
include __DIR__ . '/../Boundary/create_profile.php';
