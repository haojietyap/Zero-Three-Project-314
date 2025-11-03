<?php
class updateMyRequestBoundary {

    public function showEditForm(int $requestID, array $requestData, array $errors = [], array $old = []): void {
        echo "<h2>Edit Request #{$requestID}</h2>";

        if (!empty($errors)) {
            echo "<div style='color:red;'><ul>";
            foreach ($errors as $e) echo "<li>$e</li>";
            echo "</ul></div>";
        }

        echo "
        <form method='post'>
            Title: <input type='text' name='title' value='" . htmlspecialchars($requestData['title'] ?? '') . "'><br>
            Description: <textarea name='description'>" . htmlspecialchars($requestData['description'] ?? '') . "</textarea><br>
            Priority: <input type='text' name='priority' value='" . htmlspecialchars($requestData['priority'] ?? '') . "'><br>
            Status: <input type='text' name='status' value='" . htmlspecialchars($requestData['status'] ?? '') . "'><br>
            <button type='submit' name='update'>Update</button>
        </form>";
    }

    public function getFormData(): array {
        return [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'priority' => $_POST['priority'] ?? '',
            'status' => $_POST['status'] ?? '',
        ];
    }

    public function showSuccess(int $requestID): void {
        echo "<p style='color:green;'>Request #{$requestID} updated successfully!</p>";
        echo "<a href='index.php'>Back to list</a>";
    }

    public function showError(string $message): void {
        echo "<p style='color:red;'>$message</p>";
        echo "<a href='index.php'>Back to list</a>";
    }
}
?>
