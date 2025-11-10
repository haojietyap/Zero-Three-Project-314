<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class RequestShortlistCountController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new RequestShortlistCountBoundary();
        $this->entity = new Request();
    }

    public function showCount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $requestID = $this->boundary->getSelectedRequestID();
            $shortlistCount = $this->entity->getShortlistCount($requestID);
            $this->boundary->displayShortlistCountForm($shortlistCount, $requestID);
        } else {
            $this->boundary->displayShortlistCountForm();
        }
    }
}
?>
