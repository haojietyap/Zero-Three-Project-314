<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database/db_connect.php';
require_once __DIR__ . '/../Entity/Profile.php';

function redirect(string $to, array $qs = []): void {
    if ($qs) $to .= (strpos($to, '?') === false ? '?' : '&') . http_build_query($qs);
    header("Location: $to"); exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
if ($id <= 0) redirect('./ViewProfilesController.php', ['error' => 'Missing profile id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role        = $_POST['role'] ?? '';
    $permissions = trim($_POST['permissions'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // this validates the role if it is an allowed ENUM option
    if (!in_array($role, Profile::allowedRoles(), true)) {
        redirect("./EditProfileController.php", ['id' => $id, 'error' => 'Invalid role selected.']);
    }

    // this validates the required text fields
    if ($permissions === '' || $description === '') {
        redirect("./EditProfileController.php", ['id' => $id, 'error' => 'Permissions and description are required.']);
    }

    // this pprevents any duplicates when changing role
    if (Profile::existsByRoleForOther($conn, $role, $id)) {
        redirect("./EditProfileController.php", ['id' => $id, 'error' => 'Another profile already uses this role.']);
    }

    $ok = Profile::update($conn, $id, $role, $permissions, $description);
    $ok
        ? redirect('./ViewProfilesController.php', ['msg' => 'Profile updated.'])
        : redirect("./EditProfileController.php", ['id' => $id, 'error' => 'Update failed.']);
}

// this is the GET which loads profile for editing
$profile = Profile::findById($conn, $id);
if (!$profile) redirect('./ViewProfilesController.php', ['error' => 'Profile not found']);

$roles = Profile::allowedRoles();
$view  = 'edit';                       // this tells the Boundary to render the edit form
include __DIR__ . '/../Boundary/profile_view.php';
