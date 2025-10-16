<?php
session_start();
require_once __DIR__ . '/../../Controllers/PIN/AddFavoriteController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'PIN') {
    header("Location: ../../login.php");
    exit;
}

$PINId = $_SESSION['user']['id'];
$CSRId = $_GET['CSR_id'] ?? null;

if ($CSRId) {
    $addController = new AddFavoriteController();
    $success = $addController->add($PINId, $CSRId);
    header("Location: view_CSR.php?msg=" . ($success ? "favorited" : "failed"));
    exit;
} else {
    echo "CSR ID is missing.";
}

