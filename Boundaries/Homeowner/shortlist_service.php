<?php
session_start();
require_once __DIR__ . '/../../Controllers/PIN/ShortlistServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'PIN') {
    header("Location: ../../login.php");
    exit;
}

$PINId = $_SESSION['user']['id'];
$jobId = $_GET['job_id'] ?? null;

if ($jobId) {
    $controller = new ShortlistServiceController();
    $controller->add($PINId, $jobId);
    header("Location: view_consultation_services.php?job_id=$jobId");
    exit;
} else {
    echo "Job ID missing.";
}

