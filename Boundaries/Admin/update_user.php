<?php
session_start();
require_once __DIR__ . '/../../Controllers/User/UpdateUserController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$UpdateUserController = new UpdateUserController();

if (!isset($_GET['id'])) {
    echo "No user ID provided.";
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $UpdateUserController->updateUser($id, $name, $email, $password);
    header("Location: view_users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(120deg, #e0f7fa, #ffffff);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 13px;
            color: #2980b9;
        }

        input, select {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f1f2f6;
            font-size: 14px;
            transition: 0.3s;
        }

        input:focus, select:focus {
            background-color: #e3f2fd;
            outline: none;
            border-color: #2980b9;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #34495e;
            font-weight: 600;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #74b9ff, #2980b9);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #6c5ce7, #81ecec);
            transform: scale(1.03);
        }

        .readonly {
            background-color: #dfe6e9;
            cursor: not-allowed;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            background: linear-gradient(135deg, #81ecec, #6c5ce7);
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background: linear-gradient(135deg, #74b9ff, #a29bfe);
            transform: scale(1.03);
        }

        fieldset {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        legend {
            font-weight: bold;
            color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2><i class="fas fa-user-edit"></i> Update User: ID <?= htmlspecialchars($id) ?></h2>
		
        <form method="POST">
            <fieldset>
                <legend>New Information</legend>

                <label>New Name:</label>
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>" required>
                </div>

                <label>New Email:</label>
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
                </div>
				
				 <label>New Password:</label>
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>" required>
                </div>

                
                <button type="submit"><i class="fas fa-save"></i> Save Changes</button>
            </fieldset>
        </form>

        <a href="view_users.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to User List</a>
    </div>
</body>
</html>
