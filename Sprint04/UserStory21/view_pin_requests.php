<?php
require_once 'Controller/controller.php';

// Simulate CSR logged into the system
$controller = new ViewPINRequestsController();
$controller->showPINRequests();
?>
