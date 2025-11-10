<?php
require_once __DIR__ . '/../Entity/entity.php';
require_once __DIR__ . '/../Boundary/boundary.php';

class UpdateMyRequestController {
    private $boundary;
    private $entity;

    public function __construct() {
        $this->boundary = new UpdateMyRequestBoundary();
        $this->entity = new Request();
    }

    public function update($requestID) {
        // Load existing request info
        $request = $this->entity->getRequestById($requestID);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $data = $this->boundary->getFormData();
            $result = $this->entity->update($requestID, $data);

            if (isset($result['errors'])) {
                $this->boundary->displayUpdateRequest($data, $result['errors']);
            } else {
                echo "<p style='color:green;'>Request successfully updated! (ID: {$result['request_id']})</p>";
            }
        } else {
            $this->boundary->displayUpdateRequest($request);
        }
    }
}
?>
