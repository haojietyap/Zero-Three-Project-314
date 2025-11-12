<?php
require_once 'Controller/controller.php';

// Example: logged-in CSR user (id = 41)
$csrID = 41;

$controller = new CSRSearchHistoryController();
$controller->searchHistory($csrID);
?>
