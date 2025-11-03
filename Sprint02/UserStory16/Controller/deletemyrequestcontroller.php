<?php
require_once __DIR__ . '/../Entity/Request.php';
require_once __DIR__ . '/../Boundary/deleteMyRequestBoundary.php';

class deleteMyRequestController {

    private $boundary;

    public function __construct(deleteMyRequestBoundary $boundary) {
        $this->boundary = $boundary;
    }

    // Display confirmation
    public function confirm(int $requestID): void {
        $requests = Request::all();
        $summary = isset($requests[$requestID]) ? $requests[$requestID] : [];
        $this->boundary->confirmDelete($requestID, $summary);
    }

    // Perform deletion
    public function delete(int $requestID): void {
        $success = Request::deleteByID($requestID);
        if ($success) {
            $this->boundary->showSuccess($requestID);
        } else {
            $this->boundary->showError("Failed to delete request");
        }
    }
}
?>
