<?php
require_once 'Controller/controller.php';

// Simulate CSR logged in with ID 41
$csrID = 41;

$controller = new CSRShortlistSearchController();
$controller->searchShortlist($csrID);
?>
