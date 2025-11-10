<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';


class CreateRequestController {

    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new CreateRequestBoundary();
        $this->entity = new Request();
    }

    public function createRequest($userID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $data = $this->boundary->getFormData();
            $result = $this->entity->createRequest($userID, $data);

            if (isset($result['errors'])) {
                $this->boundary->displayCreateRequest($result['errors'], $data);
            } else {
                echo "<p style='color:green;'>Request created successfully! ID: {$result['request_id']}</p>";
            }
        } else {
            $this->boundary->displayCreateRequest();
        }
    }
}
?>
