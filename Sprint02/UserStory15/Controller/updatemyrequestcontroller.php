<?php
require_once __DIR__ . '/../Entity/Request.php';
require_once __DIR__ . '/../Boundary/updateMyRequestBoundary.php';

class updateMyRequestController {

    private updateMyRequestBoundary $boundary;

    public function __construct(updateMyRequestBoundary $boundary) {
        $this->boundary = $boundary;
    }

    public function editForm(int $requestID): void {
        $request = Request::findByID($requestID);
        if (!$request) {
            $this->boundary->showError("Request not found.");
            return;
        }
        $this->boundary->showEditForm($requestID, [
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);
    }

    public function update(int $requestID, array $data): void {
        $request = Request::findByID($requestID);
        if (!$request) {
            $this->boundary->showError("Request not found.");
            return;
        }

        $request->updateForm($data);
        $errors = $request->validateUpdate();

        if (!empty($errors)) {
            $this->boundary->showEditForm($requestID, $data, $errors);
            return;
        }

        if (!$request->save()) {
            $this->boundary->showError("Failed to update Request.");
            return;
        }

        $this->boundary->showSuccess($requestID);
    }
}
?>
