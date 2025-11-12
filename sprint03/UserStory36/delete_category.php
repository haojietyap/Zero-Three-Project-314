<?php
require_once 'Controller/controller.php';

// Example: Platform Manager wants to delete category ID #2
$categoryID = isset($_GET['id']) ? intval($_GET['id']) : 2;

$controller = new DeleteCategoryController();
$controller->delete($categoryID);
?>
