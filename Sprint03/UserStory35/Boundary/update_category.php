<?php
session_start();
require_once __DIR__ . '/../../Controller/UpdateServiceCategoryController.php';

class ViewServiceCategoryBoundary
{
    private ViewCategoriesController $controller;

    public function __construct()
    {
        $this->controller = new ViewCategoriesController();
    }

    public function displayAllCategories(): void
    {
        // Handle search keyword from GET
        $keyword = $_GET['search'] ?? '';

        if (!empty($keyword)) {
            $categories = $this->controller->searchCategories($keyword);
        } else {
            $categories = $this->controller->listAllCategories();
        }

        // Start HTML output
        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Categories</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        a { text-decoration: none; margin-right: 8px; }
        .no-data { color:red; font-weight:bold; }
    </style>
</head>
<body>
    <h1>Service Categories</h1>
    <a href="../logout.php">Logout</a>

    <form method="GET">
        <input type="text" name="search" placeholder="Search by name or description" value="{$keyword}">
        <button type="submit">Search</button>
        <a href="">Reset</a>
    </form>
HTML;

        if (empty($categories)) {
            echo "<p class='no-data'>No service categories found.</p>";
        } else {
            echo "<table>";
            echo "<thead><tr>";
            echo "<th>ID</th><th>Name</th><th>Description</th><th>Status</th><th>Created At</th><th>Actions</th>";
            echo "</tr></thead><tbody>";

            foreach ($categories as $cat) {
                $id = htmlspecialchars($cat['id']);
                $name = htmlspecialchars($cat['name']);
                $description = htmlspecialchars($cat['description']);
                $status = htmlspecialchars($cat['status'] ?? 'active');
                $createdAt = htmlspecialchars($cat['created_at']);

                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$description}</td>";
                echo "<td>{$status}</td>";
                echo "<td>{$createdAt}</td>";
                echo "<td>";
                echo "<a href='update_category.php?id={$id}'>Edit</a>";
                echo "<a href='delete_service_category.php?id={$id}' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        }

        echo '<a href="manager_dashboard.php">Back to Dashboard</a>';
        echo '</body></html>';
    }
}

// Permission check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: ../../login.php");
    exit;
}

// Show categories
$boundary = new ViewServiceCategoryBoundary();
$boundary->displayAllCategories();
