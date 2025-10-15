<?php
session_start();
require_once __DIR__ . '/../../Controllers/Cleaning Services/SuspendCleaningServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cleaner') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No job ID specified.";
    exit;
}

$jobId = $_GET['id'];
$SuspendController = new SuspendCleaningServiceController();
$success = $SuspendController->suspend($jobId);

header("Location: view_my_services.php");
exit;
?>
