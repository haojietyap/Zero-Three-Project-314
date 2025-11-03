<?php
require_once __DIR__ . '/Boundary/updateMyRequestBoundary.php';
require_once __DIR__ . '/Controller/updateMyRequestController.php';
require_once __DIR__ . '/Entity/Request.php';
require_once __DIR__ . '/seed.php';

$boundary = new updateMyRequestBoundary();
$controller = new updateMyRequestController($boundary);

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $controller->editForm($id);
} elseif (isset($_POST['update'])) {
    $controller->update($_GET['id'] ?? 1, $boundary->getFormData());
} else {
    echo "<h1>My Requests</h1><ul>";
    foreach (Request::all() as $req) {
        echo "<li>{$req['title']} 
              (<a href='?edit={$req['id']}'>Edit</a>)</li>";
    }
    echo "</ul>";
}
?>
