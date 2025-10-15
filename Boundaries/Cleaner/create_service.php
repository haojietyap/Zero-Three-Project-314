<?php
session_start();
require_once __DIR__ . '/../../Controllers/Cleaning Services/CreateCleaningServiceController.php';
require_once __DIR__ . '/../../Controllers/Service Category/ViewServiceCategoryController.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cleaner') {
    header("Location: login.php");
    exit;
}

$createCleaningServiceController = new CreateCleaningServiceController();
$viewServiceCategoryController = new ViewServiceCategoryController();
$categories = $viewServiceCategoryController->getAllCategories();

$message = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $categoryId = $_POST['category_id']; 
    $cleanerId = $_SESSION['user']['id'];
	$price = $_POST['price'];

    if ($createCleaningServiceController->createService($cleanerId, $title, $description, $categoryId, $price)) {
        $message = "Service created successfully.";
    } else {
        $message = "Error creating service.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Cleaning Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            font-family: 'Inter', sans-serif;
            color: #333;
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
        }

        nav a.logout-link {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
        }

        nav a.logout-link:hover {
            color: #e67e22;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        h2 {
            font-size: 28px;
            margin-bottom: 28px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 16px;
            font-family: 'Inter', sans-serif;
        }

        textarea {
            resize: none;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
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
        <h1>Create Service</h1>
        <a class="reset-link" href="../logout.php">Logout</a>
    </nav>

    <div class="container">
        <h2>Create Cleaning Service</h2>

        <?php if ($message): ?>
            <div class="message" style="color:<?= strpos($message, 'successfully') !== false ? 'green' : 'red' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
		<label>Service Category:</label>
			<select name="category_id" required>
				<option value="">-- Select Category --</option>
				<?php foreach ($categories as $category): ?>
				<option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
			<?php endforeach; ?>
			</select>

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="5" required></textarea>
			
			<label for="price">Price($):</label>
			<input type="text" id="price" name="price" required>

            <button type="submit">Create Service</button>
        </form>

        <a class="back-link" href="cleaner_dashboard.php">Back to Dashboard</a>
    </div>

</body>
</html>
