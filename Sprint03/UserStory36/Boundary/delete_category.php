<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/DeleteServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No category ID provided.";
    exit;
}

$categoryId = $_GET['id'];
$deleteServiceCategoryController = new DeleteServiceCategoryController();;


if ($deleteServiceCategoryController->delete($categoryId)) {
    header("Location: view_service_categories.php?msg=delete");
} else {
    echo "Failed to delete the category.";
}
?>

