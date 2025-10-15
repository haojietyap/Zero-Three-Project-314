<?php
session_start();
require_once __DIR__ . '/../../Controllers/Homeowner/ShortlistServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'homeowner') {
    header("Location: ../../login.php");
    exit;
}

$homeownerId = $_SESSION['user']['id'];
$jobId = $_GET['job_id'] ?? null;

if ($jobId) {
    $controller = new ShortlistServiceController();
    $controller->add($homeownerId, $jobId);
    header("Location: view_cleaner_services.php?job_id=$jobId");
    exit;
} else {
    echo "Job ID missing.";
}
