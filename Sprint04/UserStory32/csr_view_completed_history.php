<?php
require_once 'Controller/controller.php';

// Simulated logged-in CSR user
$csrID = 41;

$controller = new CSRViewHistoryController();
$controller->listCompletedRequest($csrID);
?>
