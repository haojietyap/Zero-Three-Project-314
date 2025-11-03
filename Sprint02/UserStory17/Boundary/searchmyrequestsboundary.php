<?php
require_once __DIR__ . '/../Controller/searchMyRequestsController.php';

class searchMyRequestsBoundary {
    private searchMyRequestsController $controller;

    public function __construct() {
        $this->controller = new searchMyRequestsController();
    }

    public function getSearchInput(): array {
        return [
            'title' => $_GET['title'] ?? '',
            'status' => $_GET['status'] ?? ''
        ];
    }

    public function renderResults(array $requests): void {
        echo "<h2>Search Results</h2>";
        echo "<table border='1'><tr><th>ID</th><th>Title</th><th>Status</th><th>Created At</th></tr>";
        foreach ($requests as $req) {
            echo "<tr>
                    <td>{$req->id}</td>
                    <td>{$req->title}</td>
                    <td>{$req->status}</td>
                    <td>{$req->createdAt}</td>
                  </tr>";
        }
        echo "</table>";
    }

    public function renderEmpty(): void {
        echo "<p>No matching requests found.</p>";
    }

    public function handleSearch(int $userID): void {
        $criteria = $this->getSearchInput();
        $results = $this->controller->search($userID, $criteria);

        if (empty($results)) {
            $this->renderEmpty();
        } else {
            $this->renderResults($results);
        }
    }
}
