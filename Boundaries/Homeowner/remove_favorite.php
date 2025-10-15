<?php
session_start();
require_once __DIR__ . '/../../Controllers/Homeowner/RemoveFavoriteController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

$homeownerId = $_SESSION['user']['id'];
$cleanerId = $_GET['cleaner_id'] ?? null;

if ($cleanerId) {
    $removeFavoriteController = new RemoveFavoriteController();
    $success = $removeFavoriteController->remove($homeownerId, $cleanerId);
    $msg = $success ? 'removed' : 'error';
    header("Location: view_favorites.php?msg=$msg");
    exit;
} else {
    echo "Cleaner ID is missing.";
}
