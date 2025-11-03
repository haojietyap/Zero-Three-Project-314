<?php
class createRequestBoundary {

    public function displayForm(array $errors = [], array $old = []): void {
        echo "<h2>Create Request</h2>";

        if (!empty($errors)) {
            echo "<div style='color:red'><ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul></div>";
        }

        $title = htmlspecialchars($old['title'] ?? '');
        $description = htmlspecialchars($old['description'] ?? '');
        $priority = htmlspecialchars($old['priority'] ?? '');

        echo <<<FORM
        <form method="post">
            <label>Title: <input type="text" name="title" value="$title"></label><br><br>
            <label>Description: <textarea name="description">$description</textarea></label><br><br>
            <label>Priority:
                <select name="priority">
                    <option value="Low"   {$this->selected($priority, 'Low')}>Low</option>
                    <option value="Medium"{$this->selected($priority, 'Medium')}>Medium</option>
                    <option value="High"  {$this->selected($priority, 'High')}>High</option>
                </select>
            </label><br><br>
            <button type="submit" name="submit">Submit</button>
        </form>
        FORM;
    }

    private function selected(string $value, string $option): string {
        return $value === $option ? 'selected' : '';
    }

    public function getFormData(): array {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'priority' => $_POST['priority'] ?? '',
            ];
        }
        return [];
    }

    public function showSuccess(int $requestID): void {
        echo "<h3 style='color:green'>Request successfully created! Request ID: $requestID</h3>";
    }

    public function showError(array $errors): void {
        $this->displayForm($errors, $_POST);
    }
}
?>
