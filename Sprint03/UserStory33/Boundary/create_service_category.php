<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/CreateServiceCategoryController.php';
require_once __DIR__ . '/../../Boundaries/ServiceCategory/CreateServiceCategoryBoundary.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$boundary = new CreateServiceCategoryBoundary();
$controller = new CreateServiceCategoryController();

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data from boundary
    $old = $boundary->getFormData();

    // Pass array to controller
    $result = $controller->createCategory($old);

    if ($result['status'] === 'exists') {
        $errors[] = "Category already exists.";
        $boundary->displayForm($errors, $old);
    } elseif ($result['status'] === 'success') {
        $boundary->showSuccess($result['id']);
    } else {
        $errors[] = "Error. Please try again.";
        $boundary->displayForm($errors, $old);
    }
} else {
    // First time page load
    $boundary->displayForm();
}
