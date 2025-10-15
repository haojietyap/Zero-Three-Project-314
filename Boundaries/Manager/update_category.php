<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/UpdateServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$updateServiceCategoryController = new UpdateServiceCategoryController();

if (!isset($_GET['id'])) {
    echo "No category ID provided.";
    exit;
}

$categoryId = $_GET['id'];
$category = $updateServiceCategoryController->getCategoryById($categoryId);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'] ?? '';
    $newDescription = $_POST['description'] ?? '';

    if (!empty($newName) && !empty($newDescription)) {
        if ($updateServiceCategoryController->update($categoryId, $newName, $newDescription)) {
            $message = "Category updated successfully.";
            $category = $updateServiceCategoryController->getCategoryById($categoryId);
        } else {
            $message = "Failed to update category.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Service Category</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: url('../img/update.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: rgba(0, 0, 0, 0.65);
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 24px;
            color: #facc15;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #f3f4f6;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 2px solid #fff;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 15px;
            margin-bottom: 16px;
            transition: 0.3s ease;
        }

        input[type="text"]:focus {
            background: rgba(255, 255, 255, 0.25);
            outline: none;
            border-color: #3b82f6;
        }

        .button {
            width: 100%;
            padding: 14px;
            background-color: #3b82f6;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 12px;
        }

        .button:hover {
            background-color: #2563eb;
        }

        .message {
            margin-top: 16px;
            padding: 12px;
            background-color: rgba(34, 197, 94, 0.2);
            color: #bbf7d0;
            border-left: 4px solid #22c55e;
            border-radius: 10px;
        }

        fieldset {
            border: none;
            margin-bottom: 24px;
            padding: 0;
        }

        legend {
            font-weight: 600;
            font-size: 16px;
            color: #facc15;
            margin-bottom: 12px;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #3b82f6;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #2563eb;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Category</h2>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>


    <form method="POST">
        <label>New Name:</label>
        <input type="text" name="name" required>

        <label>New Description:</label>
        <input type="text" name="description" required>

        <button type="submit" class="button">Save Changes</button>
    </form>

    <a href="view_service_categories.php" class="back-link">← Back to Categories</a>
</div>

</body>
</html>
