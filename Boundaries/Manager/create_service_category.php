<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/CreateServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$message = '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $createServiceCategoryController = new CreateServiceCategoryController();
	$result = $createServiceCategoryController->createCategory($name, $description);


    if ($result === 'exists') {
        $message = "Category already exists.";
    } elseif ($result === 'success') {
        $message = "Category created successfully.";
    } else {
        $message = "An error occurred. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Service Category</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff, #ffffff);
            color: #2c3e50;
            min-height: 100vh;
        }

        nav {
            background-color: #1a252f;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        nav h1 {
            font-size: 24px;
            font-weight: 600;
        }

        nav a.logout-link {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav a.logout-link:hover {
            color: #e67e22;
        }

        .container {
            max-width: 700px;
            background: white;
            margin: 50px auto;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #34495e;
        }

        input, textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            background-color: #f7f9fa;
        }

        button {
            background-color: #2984d6;
            color: white;
            border: none;
            padding: 14px 0;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
        }

        button:hover {
            background-color: #236cb2;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .back-link {
            display: block;
            margin-top: 25px;
            text-align: center;
            color: #2984d6;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
                margin: 20px;
            }

            nav {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<nav>
    <h1>Create Service Category</h1>
    <a class="logout-link" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>

<div class="container">
    <h2>New Category Info</h2>

    <?php if ($message): ?>
        <p class="message <?= $result === 'success' ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <label>Category Name:</label>
        <input type="text" name="name" placeholder="e.g. Deep Cleaning" required>

        <label>Description:</label>
        <textarea name="description" placeholder="Brief description of this service..." rows="4" required></textarea>

        <button type="submit">Create Category</button>
    </form>

    <a class="back-link" href="manager_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
