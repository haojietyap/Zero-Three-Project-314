<?php
session_start();
require_once __DIR__ . '/../../Controllers/ConfirmedJobs/MarkJobCompletedController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cleaner') {
    header("Location: ../../login.php");
    exit;
}

if (isset($_GET['match_id'])) {
    $controller = new MarkJobCompletedController();
    $success = $controller->complete($_GET['match_id']);

    $redirect = 'view_confirmed_jobs_cleaner.php';
    header("Location: $redirect?status=" . ($success ? 'updated' : 'failed'));
    exit;
}
?>
