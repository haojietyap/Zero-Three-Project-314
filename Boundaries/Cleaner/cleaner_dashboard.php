<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'cleaner') {
    header("Location: login.php");
    exit;
}

$cleanerName = $_SESSION['user']['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cleaner Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            color: #333;
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
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav a.logout-link:hover {
            color: #e67e22;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        h2 {
            font-size: 28px;
            margin-bottom: 28px;
        }

        h3 {
            margin: 30px 0 20px;
            font-size: 22px;
            color: #2c3e50;
        }

        p {
            margin-top: 10px;
            color: #555;
            font-size: 16px;
        }

        ul {
			display: flex;
			flex-direction: column;
			gap: 20px;
			padding: 0;
			list-style: none;
			margin: 0;
		}

        ul li {
            background: #f9f9f9;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }

        ul li:hover {
            background: #e3f2fd;
            transform: translateY(-4px);
        }

        ul li a {
            text-decoration: none;
            color: #2980b9;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 16px;
        }

        ul li a i {
            font-size: 18px;
        }

        a, button {
            transition: all 0.3s ease;
        }

        @media (max-width: 600px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
        
            }

            .container {
                margin: 20px;
                padding: 20px;
            }

            ul.menu {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <nav>
        <h1>Cleaner Dashboard</h1>
        <a class="logout-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

    <div class="container">
        <h2>Welcome, Cleaner🧹</h2>
        <p>You are logged in as: <strong><?= htmlspecialchars($cleanerName) ?></strong></p>

        <h3>Menu:</h3>
        <ul class="menu">
            <li><a href="create_service.php"><i class="fas fa-plus-circle"></i> Create Service</a></li>
            <li><a href="view_my_services.php"><i class="fas fa-list-alt"></i> View My Services</a></li>
			<li><a href="view_confirmed_jobs_cleaner.php"><i class="fa-solid fa-eye"></i> View Confirmed Jobs</a></li>
			<li><a href="view_completed_stats_cleaner.php"><i class="fas fa-list-alt"></i> View Completed Jobs</a></li>
        </ul>
    </div>

</body>
</html>