<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class DeleteMyRequestController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new DeleteMyRequestBoundary();
        $this->entity = new Request();
    }

    public function delete($requestID) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $confirmation = $this->boundary->getConfirmation();

            if ($confirmation === 'yes') {
                $result = $this->entity->deleteByID($requestID);

                if ($result['success']) {
                    echo "<p style='color:green;'>Request ID $requestID deleted successfully.</p>";
                } else {
                    echo "<p style='color:red;'>Error: {$result['message']}</p>";
                }
            } else {
                echo "<p>Deletion cancelled.</p>";
            }
        } else {
            $this->boundary->displayConfirmation($requestID);
        }
    }
}
?>
