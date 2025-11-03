<?php
// Boundary/viewMyRequestsBoundary.php

require_once __DIR__ . '/../Controller/viewMyRequestsController.php';

class viewMyRequestsBoundary {

    private viewMyRequestsController $controller;

    public function __construct() {
        $this->controller = new viewMyRequestsController();
    }

    public function viewMyRequests(int $userID): void {
        try {
            $requests = $this->controller->showMyRequests($userID);

            if (empty($requests)) {
                $this->renderEmpty();
            } else {
                $this->renderList($requests);
            }

        } catch (Exception $e) {
            $this->renderError($e->getMessage());
        }
    }

    public function renderList(array $requests): void {
        echo "<h2>My Requests</h2>";
        echo "<ul>";
        foreach ($requests as $req) {
            echo "<li><strong>{$req->title}</strong> - {$req->status} (Created: {$req->createdAt})</li>";
        }
        echo "</ul>";
    }

    public function renderEmpty(): void {
        echo "<p>No requests available.</p>";
    }

    public function renderError(string $message): void {
        echo "<p style='color:red;'>Error: $message</p>";
    }
}
?>
