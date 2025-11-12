<?php
require_once 'Controller/controller.php';

// Example: CSR user_id = 41, selecting a request_id = 2
$csrID = 41;
$requestID = 2;

$controller = new CSRShortlistController();
$controller->addToShortlist($csrID, $requestID);
?>
