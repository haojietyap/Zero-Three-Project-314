<?php
session_start();
require_once __DIR__ . '/../../Controllers/PIN/RemoveFavoriteController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'PIN') {
    header("Location: ../../login.php");
    exit;
}

$PINId = $_SESSION['user']['id'];
$CSRId = $_GET['CSR_id'] ?? null;

if ($CSRId) {
    $removeFavoriteController = new RemoveFavoriteController();
    $success = $removeFavoriteController->remove($PINId, $CSRId);
    $msg = $success ? 'removed' : 'error';
    header("Location: view_favorites.php?msg=$msg");
    exit;
} else {
    echo "CSR ID is missing.";
}

