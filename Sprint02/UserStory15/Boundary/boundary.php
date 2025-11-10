<?php
class UpdateMyRequestBoundary {

    // Display update form
    public function displayUpdateRequest($request = null, $errors = []) {
        echo "<h2>Update Request</h2>";

        if (!empty($errors)) {
            echo "<div style='color:red;'>";
            foreach ($errors as $error) echo "<p>$error</p>";
            echo "</div>";
        }

        if (!$request) {
            echo "<p>No request selected for update.</p>";
            return;
        }

        ?>
        <form method="POST">
            <input type="hidden" name="request_id" value="<?= $request['request_id'] ?>">

            <label>Title:</label><br>
            <input type="text" name="title" value="<?= htmlspecialchars($request['title']) ?>" required><br>

            <label>Description:</label><br>
            <textarea name="description" required><?= htmlspecialchars($request['description']) ?></textarea><br>

            <label>Location:</label><br>
            <input type="text" name="location" value="<?= htmlspecialchars($request['location']) ?>" required><br>

            <label>Preferred Date:</label><br>
            <input type="date" name="preferred_date" value="<?= htmlspecialchars($request['preferred_date']) ?>" required><br>

            <button type="submit" name="update">Update</button>
        </form>
        <?php
    }

    // Collect updated form data
    public function getFormData() {
        return [
            'request_id' => $_POST['request_id'] ?? '',
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'preferred_date' => $_POST['preferred_date'] ?? ''
        ];
    }
}
?>
