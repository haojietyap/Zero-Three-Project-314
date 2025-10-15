<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/SuspendServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No category ID provided.";
    exit;
}

$categoryId = $_GET['id'];
$suspendServiceCategoryController = new SuspendServiceCategoryController();;


if ($suspendServiceCategoryController->suspend($categoryId)) {
    header("Location: view_service_categories.php?msg=suspended");
} else {
    echo "Failed to suspend the category.";
}
?>
