<?php
session_start();
require_once __DIR__ . '/../../Controller/CreateServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$controller = new CreateServiceCategoryController();

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data directly from POST
    $old['category_name'] = trim($_POST['category_name'] ?? '');

    // Validate
    if (empty($old['category_name'])) {
        $errors[] = "Category name is required.";
    }

    // If no errors, try to create category
    if (empty($errors)) {
        $result = $controller->createCategory($old);

        if ($result['status'] === 'exists') {
            $errors[] = "Category already exists.";
        } elseif ($result['status'] === 'success') {
            $successMessage = "Category created successfully! (ID: " . htmlspecialchars($result['id']) . ")";
            $old = []; // clear form
        } else {
            $errors[] = "Error. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Service Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        header {
            background: #283e4a;
            color: #fff;
            padding: 1rem 2rem;
        }
        main {
            max-width: 800px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        footer {
            text-align: center;
            padding: 1rem;
            color: #888;
            font-size: 0.9rem;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .error {
            background: #ffe6e6;
            border: 1px solid #ffb3b3;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            color: #cc0000;
        }
        .success {
            background: #e6ffed;
            border: 1px solid #b3ffcc;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            color: #006600;
        }

        form {
            background: #f9fafc;
            border: 1px solid #ddd;
            padding: 1.5rem;
            border-radius: 6px;
        }
        form label {
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
        }
        form input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        form button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>Service Category Management</h1>
    </header>

    <main>
        <a href="../dashboard.php" class="back-link">← Back to Dashboard</a>
        <h2>Create New Category</h2>

        <!-- Display messages -->
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php elseif (!empty($successMessage)): ?>
            <div class="success">
                <p><?= htmlspecialchars($successMessage) ?></p>
            </div>
        <?php endif; ?>

        <!-- FORM SECTION -->
        <form method="POST" action="">
            <label for="category_name">Category Name:</label>
            <input 
                type="text" 
                name="category_name" 
                id="category_name" 
                value="<?= htmlspecialchars($old['category_name'] ?? '') ?>" 
                required
            >

            <button type="submit">Create Category</button>
        </form>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Service Management System</p>
    </footer>
</body>
</html>
