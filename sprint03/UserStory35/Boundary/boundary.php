<?php
class UpdateCategoryBoundary {

    // Display form for updating a category
    public function displayUpdateCategory($category = [], $errors = []) {
        echo "<h2>Update Volunteer Service Category</h2>";

        if (!empty($errors)) {
            echo "<p style='color:red;'>".implode("<br>", $errors)."</p>";
        }

        $id = htmlspecialchars($category['category_id'] ?? '');
        $name = htmlspecialchars($category['category_name'] ?? '');
        $description = htmlspecialchars($category['description'] ?? '');

        echo "
        <form method='POST'>
            <label>Category ID (Read Only):</label><br>
            <input type='text' name='category_id' value='$id' readonly><br><br>

            <label>Category Name:</label><br>
            <input type='text' name='category_name' value='$name' required><br><br>

            <label>Description:</label><br>
            <textarea name='description' rows='3' cols='30'>$description</textarea><br><br>

            <button type='submit' name='update'>Update Category</button>
        </form>
        ";
    }

    // Retrieve submitted form data
    public function getFormData() {
        return [
            'category_id' => trim($_POST['category_id'] ?? ''),
            'category_name' => trim($_POST['category_name'] ?? ''),
            'description' => trim($_POST['description'] ?? '')
        ];
    }

    // Success message
    public function displaySuccess($categoryID) {
        echo "<p style='color:green;'>✅ Category #$categoryID updated successfully!</p>";
    }
}
?>
