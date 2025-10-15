<?php
require_once __DIR__ . '/../../Controllers/User/CreateUserController.php';
$userCreation = new CreateUserController();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $result = $userCreation->createUser($name, $email, $password, $role);


    if ($result === 'exists') {
        $message = 'User already exists.';
    } elseif ($result === 'success') {
        $message = 'User created successfully.';
    } else {
        $message = 'Something went wrong. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: url('../img/createuser.jpg') no-repeat center center;
			background-size: cover;
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
            border-radius: 20px;
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

        .message {
            text-align: center;
            color: #00b894;
            font-weight: 500;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2><i class="fas fa-user-plus"></i> Create New User</h2>

        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Name:</label>
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" id="name" required>
            </div>

            <label for="email">Email:</label>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" required>
            </div>

            <label for="password">Password:</label>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="text" name="password" id="password" required>
            </div>

            <label for="role">Role:</label>
            <div class="form-group">
                <i class="fas fa-user-tag"></i>
                <select name="role" id="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin">Admin</option>
                    <option value="cleaner">Cleaner</option>
                    <option value="homeowner">Homeowner</option>
                    <option value="manager">Platform Manager</option>
                </select>
            </div>

            <button type="submit"><i class="fas fa-plus-circle"></i> Create User</button>
        </form>

        <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
