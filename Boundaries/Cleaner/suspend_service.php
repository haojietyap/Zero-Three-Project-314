<?php
session_start();
require_once __DIR__ . '/../../Controllers/Consultation Services/SuspendConsultationServiceController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'CSR') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No job ID specified.";
    exit;
}

$jobId = $_GET['id'];
$SuspendController = new SuspendConsultationServiceController();
$success = $SuspendController->suspend($jobId);

header("Location: view_my_services.php");
exit;
?>

