<?php
require_once __DIR__ . '/../Entity/Request.php';
require_once __DIR__ . '/../Boundary/createRequestBoundary.php';

class createRequestController {
    private createRequestBoundary $boundary;

    public function __construct(createRequestBoundary $boundary) {
        $this->boundary = $boundary;
    }

    public function handleForm(int $userID): void {
        $this->boundary->displayForm();
        $data = $this->boundary->getFormData();
        if (!empty($data)) {
            $this->createRequest($userID, $data);
        }
    }

    public function createRequest(int $userID, array $data): void {
        $request = new Request($userID, $data['title'], $data['description'], $data['priority']);
        $errors = $request->validate();

        if (!empty($errors)) {
            $this->boundary->showError($errors);
            return;
        }

        $request->submit();
        $requestID = $request->save();
        $this->boundary->showSuccess($requestID);
    }
}
?>
