<?php
session_start();
require_once __DIR__ . '/../../Controllers/Homeowner/AddFavoriteController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

$homeownerId = $_SESSION['user']['id'];
$cleanerId = $_GET['cleaner_id'] ?? null;

if ($cleanerId) {
    $addController = new AddFavoriteController();
    $success = $addController->add($homeownerId, $cleanerId);
    header("Location: view_cleaners.php?msg=" . ($success ? "favorited" : "failed"));
    exit;
} else {
    echo "Cleaner ID is missing.";
}
