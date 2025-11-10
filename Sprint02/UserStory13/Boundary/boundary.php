<?php
class CreateRequestBoundary {

    // Display the form for creating a request
    public function displayCreateRequest($errors = [], $old = []) {
        ?>
        <h2>Create New Request</h2>

        <?php if (!empty($errors)): ?>
            <div style="color:red;">
                <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Category ID:</label>
            <input type="number" name="category_id" value="<?= $old['category_id'] ?? '' ?>" required><br>

            <label>Title:</label>
            <input type="text" name="title" value="<?= $old['title'] ?? '' ?>" required><br>

            <label>Description:</label><br>
            <textarea name="description" required><?= $old['description'] ?? '' ?></textarea><br>

            <label>Location:</label>
            <input type="text" name="location" value="<?= $old['location'] ?? '' ?>" required><br>

            <label>Preferred Date:</label>
            <input type="date" name="preferred_date" value="<?= $old['preferred_date'] ?? '' ?>" required><br>

            <button type="submit" name="submit">Submit</button>
        </form>
        <?php
    }

    // Retrieve form data from POST
    public function getFormData() {
        return [
            'category_id' => $_POST['category_id'] ?? '',
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'preferred_date' => $_POST['preferred_date'] ?? ''
        ];
    }
}
?>
