<?php
session_start();
require_once __DIR__ . '/../../Controllers/Service Category/ViewServiceCategoryController.php';
require_once __DIR__ . '/../../Controllers/Service Category/SearchServiceCategoryController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

$viewServiceCategoryController = new ViewServiceCategoryController();
$searchServiceCategoryController = new SearchServiceCategoryController(); 

$keyword = $_GET['search'] ?? '';
$categories = !empty($keyword)
    ? $searchServiceCategoryController->search($keyword)              
    : $viewServiceCategoryController->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Service Categories</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>

        #background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
            pointer-events: none; /* So clicks pass through */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            /* Remove any background-image */
        }

        nav {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            position: relative;
        }

        nav h1 {
            font-size: 24px;
            font-weight: 600;
        }

        nav a.logout-link {
            color: #facc15;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(0, 0, 0, 0.65);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }

        h2 {
            font-size: 32px;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #fff;
        }

        form {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 12px 20px;
            border-radius: 30px;
            border: 2px solid #fff;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: 16px;
            width: 300px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            background-color: rgba(255, 255, 255, 0.5);
            border-color: #3b82f6;
            outline: none;
        }

        button,
        .reset-link {
            padding: 12px 20px;
            border: none;
            border-radius: 30px;
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        button:hover,
        .reset-link:hover {
            background-color: #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 20px;
        }

        thead {
            background-color: #2563eb;
        }

        th, td {
            padding: 16px 20px;
            text-align: left;
            color: #fff;
        }

        tbody tr {
            background-color: rgba(255, 255, 255, 0.1);
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .remove-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            color: #fff;
            text-decoration: none;
            margin-right: 6px;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
            text-align: center;
        }

        .remove-btn:hover {
            opacity: 0.9;
        }

        .update {
            background-color: #3b82f6;
        }

        .suspend {
            background-color: #ef4444;
        }

        .unsuspend {
            background-color: #f59e0b;
        }

        .status-active {
            color: #4ade80;
            font-weight: 600;
        }

        .status-suspended {
            color: #f87171;
            font-weight: 600;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #d1d5db;
            margin-top: 30px;
        }

        .back-link {
            display: block;
            margin-top: 30px;
            text-align: center;
            color: #3b82f6;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.1);
            }

            td {
                padding: 12px 16px;
                text-align: right;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 16px;
                text-align: left;
                font-weight: 600;
                color: #fff;
            }
        }
    </style>
</head>
<body>

<video autoplay muted loop playsinline id="background-video">
    <source src="../img/view_service.mp4" type="video/mp4" />
    Your browser does not support the video tag.
</video>

<nav>
    <h1>Service Categories</h1>
    <a class="logout-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>

<div class="container">
    <h2>All Categories</h2>

    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or description" value="<?= htmlspecialchars($keyword) ?>" />
        <button type="submit">Search</button>
        <a href="view_service_categories.php" class="reset-link">Reset</a>
    </form>

    <?php if (count($categories) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td data-label="Category ID"><?= $category['category_id'] ?></td>
                    <td data-label="Name"><?= htmlspecialchars($category['name']) ?></td>
                    <td data-label="Description"><?= htmlspecialchars($category['description']) ?></td>
                    <td data-label="Status" class="<?= $category['status'] === 'active' ? 'status-active' : 'status-suspended' ?>">
                        <?= ucfirst($category['status']) ?>
                    </td>
                    <td data-label="Action">
                        <div class="action-buttons">
                            <a href="update_category.php?id=<?= $category['category_id'] ?>" class="remove-btn update">Update</a>
                            <?php if ($category['status'] === 'active'): ?>
                                <a href="suspend_category.php?id=<?= $category['category_id'] ?>" class="remove-btn suspend" onclick="return confirm('Suspend this category?');">Suspend</a>
                            <?php else: ?>
                                <a class="remove-btn unsuspend">Contact Admin To Unsuspend</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-data">No service categories found.</p>
    <?php endif; ?>

    <a class="back-link" href="manager_dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>
