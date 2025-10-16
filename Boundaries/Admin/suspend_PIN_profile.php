<?php
session_start();
require_once __DIR__ . '/../../Controllers/Profiles/PIN/SuspendPINProfileController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

$userId = $_GET['id'] ?? null;

if (!$userId) {
    header("Location: manage_profiles.php");
    exit;
}

$suspendController = new SuspendPINProfileController();
$suspendController->suspend($userId);

header("Location: manage_profiles.php");
exit;

