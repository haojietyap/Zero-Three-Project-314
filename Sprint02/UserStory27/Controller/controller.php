<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class RequestViewCountController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new RequestViewCountBoundary();
        $this->entity = new Request();
    }

    public function showCount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $requestID = $this->boundary->getSelectedRequestID();
            $viewCount = $this->entity->getViewCount($requestID);
            $this->boundary->displayViewCountForm($viewCount, $requestID);
        } else {
            $this->boundary->displayViewCountForm();
        }
    }
}
?>
